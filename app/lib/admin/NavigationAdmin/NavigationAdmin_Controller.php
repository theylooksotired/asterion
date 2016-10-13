<?php
/**
* @class NavigationAdminController
*
* This is the controller for all the actions in the administration area.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class NavigationAdmin_Controller extends Controller{

    /**
    * Main function to control the administration system.
    */
    public function controlActions(){
        $ui = new NavigationAdmin_Ui($this);
        $this->mode = 'admin';
        switch ($this->action) {
            default:
                $this->login = User::loginAdmin();
                if ($this->login->user()->get('passwordTemp')!='') {
                    $linkMyInformation = '<a href="'.url('User/myAccount', true).'">'.__('here').'</a>';
                    $this->messageAlert = str_replace('#HERE', $linkMyInformation, __('changeYourTemporaryPassword'));
                }
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

}
?>