<?php
class Form {

	public function __construct($values=array(), $errors=array(), $object='') {
		//A form is created using an XML model, it uses values and errors with the same names as the object properties
		if (!is_object($object)) {
			$this->className = str_replace('_Form', '', get_class($this));
			$this->object = new $this->className($values);			
		} else {
			$this->object = $object;
			$this->className = $object->className;
		}
		$this->values = $values;
		$this->errors = $errors;
 		$this->prepareValues();
	}

	public function newArray($values=array(), $errors=array()) {
		//Return an object using new values and errors
		$formClass = get_class($this);
		return new $formClass($values, $errors);
	}

	static public function newObject($object) {
		//Create a form from an object
		$formClass = get_class($object).'_Form';
		return new $formClass($object->values, array(), $object);
	}

	public function get($name) {
		//Get a form value
		return (isset($this->$name)) ? $this->$name : '';
	}

	public function getValues() {
		//Get all the form values
		return $this->values;
	}

	public function setValue($key, $value) {
		//Set a form value
		$this->values[$key] = $value;
	}

	public function addValues($values, $errors=array()) {
		//Add values to the form
		$this->values = array_merge($this->values, $values);
		$this->errors = array_merge($this->errors, $errors);
	}

	public function prepareValues() {
		//Prepare the values
		foreach($this->object->getAttributes() as $item) {
			$name = (string)$item->name;
			$this->values[$name] = isset($this->values[$name]) ? $this->values[$name] : '';
			$this->errors[$name] = isset($this->errors[$name]) ? $this->errors[$name] : '';
			switch((string)$item->type) {
				default:
					if ((string)$item->lang == 'true') {
						foreach (Lang::langs() as $lang) {
							$nameLang = $name.'_'.$lang;
							$this->values[$nameLang] = isset($this->values[$nameLang]) ? $this->values[$nameLang] : '';
							$this->errors[$nameLang] = isset($this->errors[$nameLang]) ? $this->errors[$nameLang] : '';
						}
					}
				break;
				case 'checkbox':
					$this->values[$name] = (isset($this->values[$name])) ? $this->values[$name] : 0;
					$this->values[$name] = ($this->values[$name]==='on') ? 1 : $this->values[$name];
				break;
				case 'point':
					$this->values[$name.'_lat'] = (isset($this->values[$name.'_lat'])) ? $this->values[$name.'_lat'] : '';
					$this->values[$name.'_lng'] = (isset($this->values[$name.'_lng'])) ? $this->values[$name.'_lng'] : '';
				break;
			}
		}
	}
	
	public function createFormFields($options=array()) {
		//Create the form fields
		$html = '';
		$options['multiple'] = (isset($options['multiple']) && $options['multiple']) ? true : false;
		$options['idMultiple'] = ($options['multiple']) ? md5(rand()*rand()*rand()) : '';
		$options['idMultiple'] = (isset($options['idMultipleJs']) && $options['idMultipleJs']!='') ? $options['idMultipleJs'] : $options['idMultiple'];
		$options['nameMultiple'] = (isset($options['nameMultiple'])) ? $options['nameMultiple'] : '';
		if ($this->object->hasOrd()) {
			$nameOrd = ($options['nameMultiple']!='') ? $options['nameMultiple'].'['.$options['idMultiple'].'][ord]' : 'ord';
			$html .= FormFields_Hidden::create(array_merge(array('name'=>$nameOrd, 'value'=>$this->object->get('ord'), 'class'=>'fieldOrd'), $options));
		}
		foreach($this->object->getAttributes() as $item) {
			if (!((string)$item->type=='password' && $this->object->get('password')!='')) {
				$html .= $this->createFormField($item, $options);
			}
		}
		return $html;
	}

	public function createFormField($item, $options=array()) {
		//Create the form field
		$name = (string)$item->name;
		$label = (string)$item->label;
		$type = (string)$item->type;
		$options = array_merge($options, 
								array('item'=>$item, 
										'values'=>$this->values, 
										'errors'=>$this->errors, 
										'object'=>$this->object));
		switch (Db_ObjectType::baseType($type)) {
			default:
				return FormFields::show($type, $options);
			break;
			case 'id':
			case 'linkid':
			case 'hidden':
				switch ($type) {
					default:
						return FormFields::show('hidden', $options);
					break;
					case 'hidden-login':
						$login = User_Login::getInstance();
						$options['values'][$name] = $login->id();
						return FormFields::show('hidden', $options);
					break;
				}
			break;
			case 'multiple':
				switch($type) {
					case 'multiple-select':
						$this->object->loadMultipleValuesAll();
						$refObject = (string)$item->refObject;
						$refObjectIns = new $refObject();
						$selected = array();
						foreach($refObjectIns->basicInfoArray() as $key=>$item) {
							foreach($this->object->get($name) as $itemsIns) {
								if ($key == $itemsIns[$refObjectIns->primary]) {
									$selected[] = $key;
								}
							}
						}
						$options = array('name'=>$name.'[]',
											'label'=>$label,
											'multiple'=>true,
											'size'=>'5',
											'value'=>$refObjectIns->basicInfoAdminArray(),
											'selected'=>$selected);
						$multipleSelected = FormFields_Select::create($options);
						return '<div class="multipleCheckboxes">
									<div class="multipleCheckboxesIns">
										'.$multipleSelected.'
									</div>
								</div>';
					break;
					case 'multiple-autocomplete':
						$this->object->loadMultipleValuesAll();
						$refObject = (string)$item->refObject;
						$refObjectIns = new $refObject();
						$refAttribute = (string)$item->refAttribute;
						$autocompleteItems = '';
						foreach($refObjectIns->basicInfoArray() as $key=>$item) {
							foreach($this->object->get($name) as $itemsIns) {
								if ($key == $itemsIns[$refObjectIns->primary]) {
									$autocompleteItems .= $item.', ';
								}
							}
						}
						$autocompleteItems = substr($autocompleteItems, 0, -2);
						$options = array('name'=>$name,
											'label'=>$label,
											'size'=>'60',
											'value'=>$autocompleteItems);
						$autocomplete = FormFields_Text::create($options);
						return '<div class="autocompleteItem" rel="'.url($refObject.'/autocomplete/'.$refAttribute, true).'">
									<div class="autocompleteItemIns">
										'.$autocomplete.'
									</div>
								</div>';
					break;
					case 'multiple-checkbox':
						$this->object->loadMultipleValuesAll();
						$refObject = (string)$item->refObject;
						$refObjectIns = new $refObject();
						$label = ((string)$item->label!='') ? '<label>'.__((string)$item->label).'</label>' : '';
						$multipleCheckbox = '';
						foreach($refObjectIns->basicInfoAdminArray() as $key=>$item) {
							$value = 0;
							foreach($this->object->get($name) as $itemsIns) {
								if ($key == $itemsIns[$refObjectIns->primary]) {
									$value = 1;
								}
							}
							$options = array('name'=>$name.'['.$key.']',
											'label'=>$item,
											'value'=>$value);
							$multipleCheckbox .= FormFields_Checkbox::create($options);
						}
						return '<div class="multipleCheckboxes">
									'.$label.'
									<div class="multipleCheckboxesIns">
										'.$multipleCheckbox.'
									</div>
								</div>';
					break;
					case 'multiple-object':
						$this->object->loadMultipleValuesAll();
						$refObject = (string)$item->refObject;
						$refObjectForm = $refObject.'_Form';
						$nestedFormFields = '';
						$multipleOptions = array('multiple'=>true, 'nameMultiple'=>$name, 'idMultipleJs'=>'#ID_MULTIPLE#');
						$refObjectFormIns = new $refObjectForm();
						$label = ((string)$item->label!='') ? '<label>'.__((string)$item->label).'</label>' : '';
						$orderNested = ($refObjectFormIns->object->hasOrd()) ? '<div class="nestedFormFieldsOrder"></div>' : '';
						$nestedFormFieldsEmpty = '<div class="nestedFormFieldsEmpty">
														<div class="nestedFormFieldsDelete"></div>
														'.$orderNested.'
														<div class="nestedFormFieldsContent">
															'.$refObjectFormIns->createFormFields($multipleOptions).'
														</div>
														<div class="clearer"></div>
													</div>';
						foreach ($this->object->get($name) as $itemValues) {
							$refObjectIns = new $refObject($itemValues);
							$refObjectFormIns = new $refObjectForm($itemValues, array(), $refObjectIns);
							$multipleOptionsIns = array('multiple'=>true, 'nameMultiple'=>$name);
							$orderNested = ($refObjectFormIns->object->hasOrd()) ? '<div class="nestedFormFieldsOrder"></div>' : '';
							$nestedFormFields .= '<div class="nestedFormFieldsObject">
														<div class="nestedFormFieldsDelete" rel="'.url($refObject.'/delete/'.$refObjectIns->id(), true).'"></div>
														'.$orderNested.'
														<div class="nestedFormFieldsContent">
															'.$refObjectFormIns->createFormFields($multipleOptionsIns).'
														</div>
													</div>';
						}
						$classSortable = ($refObjectFormIns->object->hasOrd()) ? 'nestedFormFieldsSortable' : '';
						return '<div class="nestedFormFields">
									'.$label.'
									<div class="nestedFormFieldsIns '.$classSortable.'">
										'.$nestedFormFields.'
									</div>
									<div class="nestedFormFieldsNew">
										'.$nestedFormFieldsEmpty.'
										<div class="nestedFormFieldsAdd">'.__('addNewRegister').'</div>
									</div>
								</div>';
					break;
				}
			break;
		}
	}

	public function field($attribute) {
		//Return a form field
		return $this->createFormField($this->object->attributeInfo($attribute));
	}

	public static function createForm($fields, $options=array()) {
		//Create a form
		$action = (isset($options['action'])) ? $options['action'] : '';
		$method = (isset($options['method'])) ? $options['method'] : 'post';
		$submit = (isset($options['submit'])) ? $options['submit'] : __('send');
		$submitName = (isset($options['submitName'])) ? $options['submitName'] : 'submit';
		$class = (isset($options['class'])) ? $options['class'] : 'formAdmin';
		$id = (isset($options['id'])) ? 'id="'.$options['id'].'"' : '';
		if ($submit=='ajax') {
			$submitButton = '<div class="submitBtn"></div>';
		} else {
			if (is_array($submit)) {
				$submitButton = '';
				foreach ($submit as $keySubmit=>$submitIns) {
					$submitButton .= '<input type="submit" name="submit-'.$keySubmit.'" class="formSubmit formSubmit'.ucwords($keySubmit).'" value="'.$submitIns.'"/>';
				}
				$submitButton = '<div class="submitButtons">
									'.$submitButton.'
									<div class="clearer"></div>
								</div>';
			} else {
				$submitButton = FormFields::show('submit', array('name'=>$submitName,
																'class'=>'formSubmit',
																'value'=>$submit));
			}
		}
		$submitButton = ($submit=='none') ? '' : $submitButton;
		return '<form '.$id.' action="'.$action.'" method="'.$method.'" enctype="multipart/form-data" class="'.$class.'" accept-charset="UTF-8">
					<fieldset>
						'.$fields.'
						'.$submitButton.'
						<div class="clearer"></div>
					</fieldset>
				</form>';
	}

	public function isValid() {
		//Check if the form is valid
		$errors = array();
		foreach($this->object->getAttributes() as $item) {
			$error = $this->isValidField($item);
			if (count($error)>0) {
				$errors = array_merge($error, $errors);
			}
		}
		return $errors;
	}

	public function isValidField($item) {
		//Checks if an item is valid
		$error = array();
		$name = (string)$item->name;
		switch ((string)$item->required) {
			case 'notEmpty':
				if ((string)$item->lang == 'true') {
					foreach (Lang::langs() as $lang) {
						if (!isset($this->values[$name.'_'.$lang]) || strlen(trim($this->values[$name.'_'.$lang])) == 0) {
							$error[$name.'_'.$lang] = __('notEmpty');
						}
					}
				} else {
					if (!isset($this->values[$name]) || strlen(trim($this->values[$name])) == 0) { 
						$error[$name] = __('notEmpty');
					}
				}
			break;
			case 'notEmptyPoint':
				if (!isset($this->values[$name.'_lat']) || strlen(trim($this->values[$name.'_lat'])) == 0) { 
					$error[$name] = __('notEmpty');
				}
				if (!isset($this->values[$name.'_lng']) || strlen(trim($this->values[$name.'_lng'])) == 0) { 
					$error[$name] = __('notEmpty');
				}
			break;
			case 'email':
				if (!isset($this->values[$name]) || strlen(trim($this->values[$name])) == 0) {
					$error[$name] = __('notEmpty');
				}
				if (!filter_var($this->values[$name], FILTER_VALIDATE_EMAIL)) {
					$error[$name] = __('errorMail');
				}
			break;
			case 'password':
				if (!isset($this->values[$name]) || strlen(trim($this->values[$name])) == 0) { 
					$error[$name] = __('notEmpty');
				} else {
					if (strlen($this->values[$name]) < 6) { 
						$error[$name] = __('errorPasswordSize');
					}
					if (preg_match('/^[a-z0-9]+$/i', $this->values[$name])==false) {
						$error[$name] = __('errorPasswordAlpha');
					}
				}
			break;
		}
		return $error;
	}

	public function isValidEmpty($field, &$errors) {
		if (!isset($this->values[$field]) || strlen(trim($this->values[$field])) == 0) { 
			$errors[$field] = __('notEmpty');
		}
	}

}
?>