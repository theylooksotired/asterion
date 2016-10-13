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
                $page = Page::code($this->action);
                if ($page->id()!='') {
                    $this->titlePage = $page->getBasicInfo();
                    $this->content = $page->showUi('Complete');
                    return $this->ui->render();
                } else {
                    header('Location: '.url());
                    exit();
                }
            break;
            case 'intro':
                $this->content = 'Here goes the content';
                return $this->ui->render();
            break;
            case 'error':
                header("HTTP/1.0 404 Not Found");
                $this->titlePage = 'Error 404';
                $this->content = 'Error 404';
                return $this->ui->render();
            break;
        }
    }

}
?>