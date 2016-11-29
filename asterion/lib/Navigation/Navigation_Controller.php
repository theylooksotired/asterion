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
                                                <a href="" class="introButton introButtonDownload">'.__('download').' <span>v.4.0.1</span></a>
                                                <a href="" class="introButton">'.__('tryDemo').'</a>
                                                <a href="" class="introButton">'.__('viewGitHub').'</a>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockMain">
                                        <div class="pageBlockContent">
                                            '.HtmlSection::show('intro').'
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockWhen">
                                        <div class="pageBlockContent">
                                            '.HtmlSection::show('when-to-use').'
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockExamples">
                                        <div class="pageBlockContent">
                                            '.HtmlSection::show('examples').'
                                        </div>
                                    </section>
                                    <section class="pageBlock pageBlockDocumentation">
                                        <div class="pageBlockContent">
                                            '.HtmlSection::show('documentation').'
                                        </div>
                                    </section>';
            break;
            case 'documentation':
                $info = explode('_', $this->id);
                $item = Documentation::read($info[0]);
                $this->layoutPage = 'documentation';
                if ($item->id()!='') {
                    $this->titlePage = $item->getBasicInfo();
                    $this->metaDescription = $item->get('shortDescription');
                    $this->metaUrl = $item->url();
                    $this->content = $item->showUi('Complete');
                } else {
                    $this->titlePage = __('documentation');
                    $items = new ListObjects('DocumentationCategory', array('order'=>'ord'));
                    $this->content = $items->showList();
                }
            break;
            case 'error':
                header("HTTP/1.0 404 Not Found");
                $this->titlePage = 'Error 404';
                $this->content = 'Error 404';
            break;
        }
        return $this->ui->render();
    }

}
?>