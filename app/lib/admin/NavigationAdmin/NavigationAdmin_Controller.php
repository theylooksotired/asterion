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
                            'app_folder'=>APP_FOLDER,
                            'site_url'=>url(''),
                            'lang'=>Lang::active());
                return 'var info_site = '.json_encode($info).';';
            break;
            case 'js-translations':
                $this->mode = 'js';
                $query = 'SELECT code, translation_'.Lang::active().' as translation
                        FROM '.Db::prefixTable('LangTrans').'
                        WHERE code LIKE "js_%"';
                $translations = array();
                $translationResults = Db::returnAll($query);
                foreach ($translationResults as $translationResult) {
                    $trasnlationValue = $translationResult['translation'];
                    $translations[$translationResult['code']] = $trasnlationValue;
                }
                return 'var info_translations = '.json_encode($translations).';';
            break;
            case 'cache-backup':
                $this->checkLoginAdmin();
                $this->titlePage = __('cacheBackup');
                $info = '';
                $objectNames = File::scanDirectoryObjects();
                sort($objectNames);
                foreach ($objectNames as $objectName) {
                    $object = new $objectName();
                    $query = 'SELECT COUNT(*) as numResults FROM '.Db::prefixTable($objectName);
                    $results = Db::returnSingle($query);
                    $info .= '<div class="blockCacheItem">
                                '.$objectName.' <span>('.$results['numResults'].' '.__('results').')</span>
                            </div>';
                }
                $this->content = '<h2>'.__('exportInformation').'</h2>
                                    <div class="blockCache">
                                        <div class="button">
                                            <a href="'.url('NavigationAdmin/backup-mysql', true).'" target="_blank">'.__('exportSql').'</a>
                                        </div>
                                    </div>
                                    <div class="blockCache">
                                        <div class="button">
                                            <a href="'.url('NavigationAdmin/backup-json', true).'">'.__('exportJson').'</a>
                                        </div>
                                    </div>
                                    <h2>'.__('availableObjects').'</h2>
                                    <div class="blockCacheItems">
                                        '.$info.'
                                    </div>';
                return $ui->render();
            break;
            case 'backup-mysql':
                $this->checkLoginAdmin();
                $this->mode = 'ajax';
                $content = shell_exec('mysqldump --user='.DB_USER.' --password='.DB_PASSWORD.' --host='.DB_SERVER.' --port='.DB_PORT.' '.DB_NAME);
                File::download('backup.sql', array('content'=>$content, 'contentType'=>'text/plain'));
                return '';
            break;
            case 'backup-json':
                $this->checkLoginAdmin();
                $this->mode = 'zip';
                $objectNames = File::scanDirectoryObjects();
                File::createDirectory(BASE_FILE.'data');
                File::createDirectory(BASE_FILE.'data/backup');
                foreach ($objectNames as $objectName) {
                    $object = new $objectName();
                    $fileJson = BASE_FILE.'data/backup/'.$objectName.'.json';
                    if ((string)$object->info->info->form->exportJson=='true') {
                        $query = 'SELECT * FROM '.Db::prefixTable($objectName);
                        $items = Db::returnAll($query);
                        File::saveFile($fileJson, json_encode($items));
                    }
                }
                $zipname = 'backup.zip';
                $files = array('readme.txt', 'test.html', 'image.gif');
                $zip = new ZipArchive;
                $zip->open($zipname, ZipArchive::CREATE);
                foreach (glob(BASE_FILE.'data/backup/*.json') as $file) {
                    $zip->addFile($file, 'backup/'.basename($file));
                }
                $zip->close();
                header('Content-disposition: attachment; filename='.$zipname);
                header('Content-Length: ' . filesize($zipname));
                readfile($zipname);
                @unlink($zipname);
                return '';
            break;
        }
    }

}
?>