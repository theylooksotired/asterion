<?php
class HtmlMailTemplate_Controller extends Controller {

	public function __construct($GET, $POST, $FILES) {
		parent::__construct($GET, $POST, $FILES);
	}

	public function controlActions(){
		$this->mode = 'admin';
		$this->object = new $this->type();
		$this->titlePage = __((string)$this->object->info->info->form->title);
		$this->layout = (string)$this->object->info->info->form->layout;
		$ui = new NavigationAdmin_Ui($this);
		switch ($this->action) {
			default:
				return parent::controlActions();
			break;
			case 'listAdmin':
				$this->checkLoginAdmin();
				$item = HtmlMailTemplate::readFirst();
				if ($item->id()!='') {
					header('Location: '.url('HtmlMailTemplate/modifyView/'.$item->id(), true));
				} else {
					return parent::controlActions();
				}
			break;
			case 'modifyView':
				$this->menuInside = '';
				$this->content = $this->modifyView(false);
				return $ui->render();
			break;
		}
	}
	
}
?>