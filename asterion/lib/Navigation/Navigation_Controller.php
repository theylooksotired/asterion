<?php
/**
* @class NavigationController
*
* This is the controller for all the public actions of the website.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Navigation_Controller extends Controller{

    /**
    * The constructor of the object.
    */
    public function __construct($GET, $POST, $FILES) {
        parent::__construct($GET, $POST, $FILES);
        $this->ui = new Navigation_Ui($this);
    }
    
    /**
    * Main function to control the public actions.
    */
    public function controlActions(){
        switch ($this->action) {
            default:
                $this->metaUrl = url('');
                $this->content = '<section class="pageBlock pageBlockIntro">
                                        <div class="pageBlockIns">
                                            <h1>'.Params::param('metainfo-metaDescription-'.Lang::active()).'</h1>
                                            <div class="introButtons">
                                                <a href="" class="introButton introButtonDownload">'.__('download').'</a>
                                                <a href="" class="introButton">'.__('tryDemo').'</a>
                                                <a href="" class="introButton">'.__('viewGitHub').'</a>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockMain">
                                        '.HtmlSection::show('intro').'
                                    </section>';
                return $this->ui->render();
            break;
            case 'error':
                header("HTTP/1.0 404 Not Found");
                $this->titlePage = 'Error 404';
                $this->content = 'Error 404';
            break;
        }
    }

}
?>