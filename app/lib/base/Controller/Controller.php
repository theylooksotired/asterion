<?php
abstract class Controller{

	protected function __construct($GET, $POST, $FILES) {
		$this->type = isset($GET['type']) ? $GET['type'] : '';
		$this->action = isset($GET['action']) ? $GET['action'] : 'list';
		$this->id = isset($GET['id']) ? $GET['id'] : '';
		$this->extraId = isset($GET['extraId']) ? $GET['extraId'] : '';
		$this->addId = isset($GET['addId']) ? $GET['addId'] : '';
		$this->params = isset($GET) ? $GET : array();
		$this->values = isset($POST) ? $POST : array();
		$this->files = isset($FILES) ? $FILES : array();
		$this->login = User_Login::getInstance();
	}
	
	public function getTitle() {
		return (isset($this->titlePage)) ? $this->titlePage.' - '.Params::param('titlePage') : Params::param('titlePage');
	}	

	public function getHeader() {
		return (isset($this->header)) ? $this->header : '';
	}

	public function getMetaDescription() {
		return (isset($this->metaDescription) && $this->metaDescription!='') ? $this->metaDescription : Params::param('metaDescription');
	}

	public function getMetaKeywords() {
		return (isset($this->metaKeywords)) ? $this->metaKeywords : Params::param('metaKeywords');
	}

	public function getMetaImage() {
		return (isset($this->metaImage) && $this->metaImage!='') ? $this->metaImage : LOGO;
	}

	public function getMode() {
		return (isset($this->mode)) ? $this->mode : 'public';
	}

	public function controlActions(){
		//Control all the main admin actions
		$this->mode = 'admin';
		$this->object = new $this->type();
		$this->titlePage = __((string)$this->object->info->info->form->title);
		$this->layout = (string)$this->object->info->info->form->layout;
		$ui = new NavigationAdmin_Ui($this);
		switch ($this->action) {
			default:
				header('Location: '.url($this->type.'/listAdmin', true));
			break;
			case 'reWriteTable':
				//Rewrite a table and eliminate all contents
				$this->checkLoginAdmin();
				$this->object->createTable(true);
				header('Location: '.url($this->type.'/listAdmin', true));
			break;
			case 'listAdmin':
				//List the items of the object
				$this->checkLoginAdmin();
				if (DEBUG) {
					//Create the table
					Db::initTable($this->object->className);
				}
				$this->menuInside = $this->menuInside();
				$this->content = $this->listAll();
				return $ui->render();
			break;
			case 'insertView':
				$this->checkLoginAdmin();
				$this->menuInside = $this->menuInside();
				$this->content = $this->insertView();
				return $ui->render();
			break;
			case 'insert':
				$this->checkLoginAdmin();
				$insert = $this->insert();
				if ($insert['success']=='1') {
					header('Location: '.url($this->type.'/insertCheck/'.$insert['id'], true));
				} else {
					$this->messageError = __('errorsForm');
					$this->menuInside = $this->menuInside();
					$this->content = $insert['html'];
					return $ui->render();
				}
			break;
			case 'insertCheck':
				$this->checkLoginAdmin();
				$this->message = __('savedForm');
				$this->menuInside = $this->menuInside();
				$this->content = $this->modifyView();
				return $ui->render();
			break;
			case 'modifyView':
			case 'modifyViewNested':
				$this->checkLoginAdmin();
				$nested = ($this->action == 'modifyViewNested') ? true : false;
				$this->menuInside = $this->menuInside();
				$this->content = $this->modifyView($nested);
				return $ui->render();
			break;
			case 'modify':
			case 'modifyNested':
				$this->checkLoginAdmin();
				$nested = ($this->action == 'modifyNested') ? true : false;
				$modify = $this->modify($nested);
				if ($modify['success']=='1') {
					if (isset($this->values['submit-saveCheck'])) {
						header('Location: '.url($this->type.'/modifyView/'.$modify['id'], true));
					} else {
						header('Location: '.url($this->type.'/listAdmin', true));
					}
				} else {
					$this->messageError = __('errorsForm');
					$this->content = $modify['html'];
					return $ui->render();
				}
			break;
			case 'delete':
				$this->checkLoginAdmin();
				$this->delete();
				header('Location: '.url($this->type.'/listAdmin', true));
			break;
			case 'sortSave':
				$this->checkLoginAdmin();
				$this->mode = 'ajax';
				$object = new $this->type();
				$newOrder = (isset($this->values['newOrder'])) ? $this->values['newOrder'] : array();
				$object->updateOrder($newOrder);
			break;
			case 'addSimple':
				$this->checkLoginAdmin();
				$this->mode = 'ajax';
				$formObject = $this->type.'_Form';
				$form = new $formObject();
				return $form->createFormFieldsMultiple();
			break;
			case 'multiple-delete':
				$this->checkLoginAdmin();
				$this->mode = 'ajax';
				if (isset($this->values['list-ids'])) {
					$type = new $this->type();
					foreach ($this->values['list-ids'] as $id) {
						$object = $type->readObject($id);
						$object->delete();
					}
				}
			break;
			case 'multiple-activate':
			case 'multiple-deactivate':
				$this->checkLoginAdmin();
				$this->mode = 'ajax';
				if (isset($this->values['list-ids'])) {
					$primary = (string)$this->object->info->info->sql->primary;
					$where = '';
					foreach ($this->values['list-ids'] as $id) {
						$where .= $primary.'="'.$id.'" OR ';
					}
					$where = substr($where, 0, -4);
					$active = ($this->action == 'multiple-activate') ? '1' : '0';
					$query = 'UPDATE '.Db::prefixTable($this->type).' SET active="'.$active.'" WHERE '.$where;
					Db::execute($query);
				}
			break;
			case 'autocomplete':
				$this->mode = 'json';
				$autocomplete = (isset($_GET['term'])) ? $_GET['term'] : '';
				if ($autocomplete!='') {
					$where = '';
					$concat = '';
					$items = explode('_', $this->id);
					foreach ($items as $itemIns) {
						$item = $this->object->attributeInfo($itemIns);
						$name = (string)$item->name;
						if (is_object($item) && $name!='') {
							$concat .= $name.'," ",';
							$where .= $name.' LIKE "%'.$autocomplete.'%" OR ';
						}
					}
					$where = substr($where, 0, -4);
					$concat = 'CONCAT('.substr($concat, 0, -5).')';
					if ($where!='') {
						$query = 'SELECT '.(string)$this->object->info->info->sql->primary.' as idItem, 
								'.$concat.' as infoItem
								FROM '.Db::prefixTable($this->object->className).'
								WHERE '.$where.'
								ORDER BY '.$name.' LIMIT 20';
						$results = array();
						$resultsAll = Db::returnAll($query);
						foreach ($resultsAll as $result) {
							$resultsIns = array();
							$resultsIns['id'] = $result['idItem'];
							$resultsIns['value'] = $result['infoItem'];
							$resultsIns['label'] = $result['infoItem'];
							array_push($results, $resultsIns);
						}
						return json_encode($results);						
					}
				}
			break;
			case 'search':
				//List the items searched
				$this->checkLoginAdmin();
				if ($this->id != '') {
					$this->content = $this->listAll();
					return $ui->render();
				} else {
					if (isset($this->values['search']) && $this->values['search']!='') {
						$searchString = urlencode(html_entity_decode($this->values['search']));
						header('Location: '.url($this->type.'/search/'.$searchString, true));
					} else {
						header('Location: '.url($this->type.'/listAdmin', true));
					}	
				}
			break;
		}
	}

	public function listAll() {
		$classUi = $this->type.'_Ui';
		// Order list
		$orderAttribute = (string)$this->object->info->info->form->orderBy;
		$order = '';
		if ($orderAttribute!='') {
			$orderInfo = $this->object->attributeInfo($orderAttribute);
			$order = (is_object($orderInfo) && (string)$orderInfo->lang == "true") ? $orderAttribute.'_'.Lang::active() : $orderAttribute;
		}
		// Multiple actions
		$multipleActionsHtml = '';
		$multipleChoice = false;
		$multipleActions = (array)$this->object->info->info->form->multipleActions->action;
		if (count($multipleActions) > 0) {
			$multipleChoice = true;
			$multipleActionsOptions = '';
			foreach ($multipleActions as $multipleAction) {
				$multipleActionsOptions .= '<div class="multipleAction multipleOption" rel="'.url($this->object->className.'/multiple-'.$multipleAction, true).'">'.__($multipleAction.'Selected').'</div>';	
			}
			$multipleActionsHtml = '<div class="multipleActions">
										<div class="multipleAction multipleActionCheckAll">
											'.FormFields_Checkbox::create(array('name'=>'checkboxList')).'
										</div>
										'.$multipleActionsOptions.'
										<div class="clearer"></div>
									</div>';
		}
		// Search form
		$search = (string)$this->object->info->info->form->search;
		$searchQuery = (string)$this->object->info->info->form->searchQuery;
		$searchValue = urldecode($this->id);
		$formSearch = '';
		if ($search!='' || $searchQuery!='') {
			$fieldsSearch = FormFields_Text::create(array('name'=>'search', 'value'=>$searchValue));
			$formSearch = '<div class="formAdminSearchWrapper">
								'.Form::createForm($fieldsSearch, array('action'=>url($this->type.'/search', true), 'submit'=>__('search'), 'class'=>'formAdminSearch')).'
								<div class="clearer"></div>
							</div>';
		}
		$searchTitle = '';
		// Group objects
		$classSort = ($this->permissions('canOrder')) ? 'sortableList' : '';
		$listItems = '';
		$group = (string)$this->object->info->info->form->group;
		if ($group!='') {
			$items = $this->object->getValues($group, true);
			$listItems = '';
			foreach ($items as $key=>$item) {
				$list = new ListObjects($this->type, array('where'=>$group.'="'.$key.'"', 'function'=>'Admin', 'order'=>$order));
				if (!$list->isEmpty()) {
					$classSort = ($this->permissions('canOrder')) ? 'sortableList' : '';
					if (!$list->isEmpty()) {
						$listItems .= '<div class="sublistAdmin">
											<h2>'.$item.'</h2>
											<div class="listAdmin '.$classSort.'" rel="'.url($this->object->className.'/sortSave/', true).'">
												'.$list->showList(array('function'=>'Admin'), array('userType'=>$this->login->get('type'), 'multipleChoice'=>$multipleChoice)).'
											</div>
										</div>';						
					}
				}
			}
		} else {
			$pager = (int)$this->object->info->info->form->pager;
			if (($search!='' || $searchQuery!='') && $searchValue!='') {
				$searchTitle = '<div class="backButton"><a href="'.url($this->object->className.'/listAdmin', true).'">&#8592; '.__('viewAllItems').'</a></div>
								<h2>'.__('resultsFor').': "'.$searchValue.'"'.'</h2>';
				if ($search!='') {
					$list = new ListObjects($this->type, array('where'=>str_replace('#SEARCH', $searchValue, $search), 'function'=>'Admin', 'order'=>$order, 'limit'=>'20'));
				} else {
					$list = new ListObjects($this->type, array('query'=>str_replace('#SEARCH', $searchValue, $searchQuery)));
				}
				$listItems = $list->pager(array('admin'=>true)).'
							<div class="listAdmin '.$classSort.'" rel="'.url($this->object->className.'/sortSave/', true).'">
								'.$list->showList(array('function'=>'Admin', 'message'=>'<div class="message">'.__('noItems').'</div>'), array('userType'=>$this->login->get('type'))).'
							</div>
							'.$list->pager(array('admin'=>true));
			} else {
				if ($pager > 0) {
					$list = new ListObjects($this->type, array('function'=>'Admin', 'order'=>$order, 'results'=>$pager));
				} else {
					$list = new ListObjects($this->type, array('function'=>'Admin', 'order'=>$order));
				}
				if (!$list->isEmpty()) {
					$listItems = $multipleActionsHtml.'
								'.$list->pager(array('admin'=>true)).'
								<div class="listAdmin '.$classSort.'" rel="'.url($this->object->className.'/sortSave/', true).'">
									'.$list->showList(array('function'=>'Admin'), array('userType'=>$this->login->get('type'), 'multipleChoice'=>$multipleChoice)).'
								</div>
								'.$list->pager(array('admin'=>true));
				}
			}
		}
		return $formSearch.'
				'.$searchTitle.'
				'.$listItems;
	}

	public function insertView() {
		//Render an insertion form
		$uiObjectName = $this->type.'_Ui';
		$uiObject = new $uiObjectName($this->object);
		return $uiObject->renderForm(array('values'=>$this->values, 'action'=>url($this->object->className.'/insert', true), 'class'=>'formAdmin formAdminInsert'));
	}

	public function modifyView($nested=false){
		//Render a modify form
		$action = ($nested) ? 'modifyNested' : 'modify';
		$this->object = $this->object->readObject($this->id);
		$uiObjectName = $this->type.'_Ui';
		$uiObject = new $uiObjectName($this->object);
		$values = array_merge($this->object->valuesArray(), $this->values);
		$submitArray = (!$nested) ? array('submit'=>array('save'=>__('save'), 'saveCheck'=>__('saveCheck'))) : array();
		return $uiObject->renderForm(array_merge(array('values'=>$values, 'action'=>url($this->object->className.'/'.$action, true), 'class'=>'formAdmin formAdminModify', 'nested'=>$nested), $submitArray));
	}

	public function insert(){
		//Insert an element and return the proper information to render
		$formClass = $this->type.'_Form';
		$form = new $formClass($this->values);
		$errors = $form->isValid();
		$object = $form->get('object');
		if (empty($errors)) {
			try {
				$object->insert($this->values);
			} catch (Exception $e) {
				$form = new $formClass($this->values, array());
				$html = '<div class="message messageError">
							'.$e->getMessage().'
						</div>
						'.$form->createForm($form->createFormFields(), array('action'=>url($this->object->className.'/insert', true), 'submit'=>__('save'), 'class'=>'formAdmin formAdminInsert'));
				return array('success'=>'0', 'html'=>$html);
			}
			$multipleChoice = (count((array)$this->object->info->info->form->multipleActions) > 0) ? true : false;
			$html = $object->showUi('Admin', array('userType'=>$this->login->get('type'), 'multipleChoice'=>$multipleChoice));
			return array('success'=>'1', 'html'=>$html, 'id'=>$object->id());
		} else {
			$form = new $formClass($this->values, $errors);
			$html = $form->createForm($form->createFormFields(), array('action'=>url($this->object->className.'/insert', true), 'submit'=>__('save'), 'class'=>'formAdmin formAdminInsert'));
			return array('success'=>'0', 'html'=>$html);
		}
	}
	
	public function modify($nested=false) {
		//Modify an element and return the proper information to render
		$action = ($nested) ? 'modifyNested' : 'modify';
		if (isset($this->values[$this->object->primary])) {
			$this->object = $this->object->readObject($this->values[$this->object->primary]);
		}
		$formClass = $this->type.'_Form';
		$form = new $formClass($this->object->values, array(), $this->object);
		$form->addValues($this->values);
		$object = $this->object;
		$errors = $form->isValid();
		if (empty($errors)) {
			try {
				$object->modify($this->values);
			} catch (Exception $e) {
				$html = '<div class="message messageError">
							'.$e->getMessage().'
						</div>
						'.Form::createForm($form->createFormFields(false, $nested), array('action'=>url($this->type.'/'.$action.'/'.$this->id, true), 'submit'=>__('save'), 'class'=>'formAdmin', 'nested'=>$nested));
				return array('success'=>'0', 'html'=>$html);
			}
			$multipleChoice = (count((array)$this->object->info->info->form->multipleActions) > 0) ? true : false;
			$html = $object->showUi('Admin', array('userType'=>$this->login->get('type'), 'multipleChoice'=>$multipleChoice, 'nested'=>$nested));
			return array('success'=>'1', 'id'=>$object->id(), 'html'=>$html);
		} else {
			$form = new $formClass($this->values, $errors);
			$html = Form::createForm($form->createFormFields(false, $nested), array('action'=>url($this->type.'/'.$action.'/'.$this->id, true), 'submit'=>__('save'), 'class'=>'formAdmin', 'nested'=>$nested));
			return array('success'=>'0', 'html'=>$html);
		}
	}

	public function delete(){
		//Delete an element and return the proper information to render
		if ($this->id != '') {
			$type = new $this->type();
			$object = $type->readObject($this->id);
			$object->delete();
		}
	}

	public function menuInside($action='') {
		//Return the menu
		$items = '';
		$action = ($action!='') ? $action : $this->action;
		switch ($action) {
			case 'listAdmin':
				if ($this->permissions('canInsert')) {
					$items = '<div class="menuSimpleItem menuSimpleItemInsert">
								<a href="'.url($this->type.'/insertView', true).'"><span></span>'.__('insertNew').'</a>
							</div>';
				}
			break;
			case 'insertView':
			case 'insert':
			case 'modifyView':
				$items = '<div class="menuSimpleItem menuSimpleItemCancel">
							<a href="'.url($this->type.'/listAdmin', true).'"><span></span>'.__('cancel').'</a>
						</div>';
			break;
			case 'insertCheck':
				$insertMenu = '';
				if ($this->permissions('canInsert')) {
					$insertMenu = '<div class="menuSimpleItem menuSimpleItemInsert">
										<a href="'.url($this->type.'/insertView', true).'"><span></span>'.__('insertNew').'</a>
									</div>';
				}
				$items = $insertMenu.'
						<div class="menuSimpleItem menuSimpleItemList">
							<a href="'.url($this->type.'/listAdmin', true).'"><span></span>'.__('viewList').'</a>
						</div>';
			break;
			case 'listBack':
				$items = '<div class="menuSimpleItem menuSimpleItemList">
							<a href="'.url($this->type.'/listAdmin', true).'"><span></span>'.__('viewList').'</a>
						</div>';
			break;

		}
		if ($items!='') {
			return '<div class="menuSimple">
						'.$items.'	
						<div class="clearer"></div>
					</div>';			
		}
	}

	// Functions to manage the permissions
	public function checkLoginAdmin() {
		if (!$this->login->isConnected()) {
			if ($this->mode == 'ajax') {
				return __('notConnected');
			} else {			
				header('Location: '.url('User/login', true));
			}
			exit();
		}
		$type = $this->login->get('type');
		$this->permissions = $this->object->info->info->form->permissions->$type;
		switch ($this->action) {
			case 'reWriteTable':
				$this->permissionsDeny('canRewrite');
			break;
			default:
			case 'listAdmin':
				$this->permissionsDeny('canViewList');
			break;
			case 'insertView':
			case 'insert':
			case 'insertCheck':
				$this->permissionsDeny('canInsert');
			break;
			case 'modifyView':
			case 'modifyViewNested':
			case 'modify':
			case 'multiple-activate':
				$this->permissionsDeny('canModify');
			break;
			case 'delete':
			case 'multiple-delete':
				$this->permissionsDeny('canDelete');
			break;
			case 'sortSave':
				$this->permissionsDeny('canOrder');
			break;
		}
	}

	function permissionsDeny($option='') {
		$urlPermissions = url('NavigationAdmin/permissions', true);
		if (!is_object($this->permissions) || (string)$this->permissions->$option != "true") {
			if ($this->mode == 'ajax') {
				return __('permissionsDeny');
			} else {			
				header('Location: '.$urlPermissions);
				exit();
			}
		}
	}

	function permissions($option) {
		return (isset($this->permissions) && is_object($this->permissions) && (string)$this->permissions->$option == "true");
	}
}
?>