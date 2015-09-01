<?php
class Navigation_Controller extends Controller{

	public function __construct($GET, $POST, $FILES) {
		parent::__construct($GET, $POST, $FILES);
		$this->ui = new Navigation_Ui($this);
	}
	
	public function controlActions(){
		switch ($this->action) {
			default:
			case 'error':
				header("HTTP/1.0 404 Not Found");
				$this->titlePage = 'Error 404';
				$this->content = 'Error 404';
				return $this->ui->render();
			break;
			case 'intro':
				$this->content = 'Here goes the content';
				return $this->ui->render();
			break;
			case 'facebook':
			case 'twitter':
			case 'linkedin':
			case 'facebook':
				header('Location: '.Url::format(Params::param('link-'.$this->action)));
				exit();
			break;
		}
	}
}
?>