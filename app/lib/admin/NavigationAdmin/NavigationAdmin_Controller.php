<?php
class NavigationAdmin_Controller extends Controller{

	public function __construct($GET, $POST, $FILES) {
		parent::__construct($GET, $POST, $FILES);
	}

	public function controlActions(){
		$ui = new NavigationAdmin_Ui($this);
		$this->mode = 'admin';
		switch ($this->action) {
			default:
			case 'intro':
				$this->login();
				$this->content = '<div class="pageIntro">'.HtmlSectionAdmin::show('intro').'</div>';
				return $ui->render();
			break;
			case 'permissions':
				$this->titlePage = TITLE;
				$this->messageError = __('permissionsError');
				return $ui->render();
			break;
			case 'base-info':
				$this->mode = 'json';
				$info = array('base_url'=>LOCAL_URL,
							'app_url'=>APP_URL,
							'site_url'=>url(''),
							'lang'=>Lang::active());
				return 'info_site = '.json_encode($info).';';
			break;
			case 'js-translations':
				$this->mode = 'json';
				$query = 'SELECT code, translation_'.Lang::active().' as translation
						FROM '.Db::prefixTable('LangTrans').'
						WHERE code LIKE "js_%"';
				$translations = array();
				$translationResults = Db::returnAll($query);
				foreach ($translationResults as $translationResult) {
					$trasnlationValue = $translationResult['translation'];
					$translations[$translationResult['code']] = $trasnlationValue;
				}
				return 'info_translations = '.json_encode($translations).';';
			break;
		}
	}

	public function login() {
		//Check if the user is connected
		$this->login = User_Login::getInstance();
		if (!$this->login->isConnected()) {
			header('Location: '.url('User/login', true));
		}
	}

}
?>