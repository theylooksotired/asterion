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
                    $this->layoutPage = 'sidebar';
                    $this->titlePage = $page->getBasicInfo();
                    $this->metaUrl = url($this->action);
                    $this->content = $page->showUi('Complete');
                } else {
                    header('Location: '.url());
                    exit();
                }
            break;
            case 'intro':
                $this->content = Banner_Ui::intro().'
                                <div class="intro">
                                    <div class="introLeft">
                                        '.Page::show('intro').'
                                    </div>
                                    <div class="introRight">
                                        '.$this->ui->sidebar().'
                                    </div>
                                </div>';
            break;
            case 'categories':
            case 'categorias':
                $info = explode('_', $this->id);
                $item = Category::read($info[0]);
                $this->layoutPage = 'sidebar';
                if ($item->id()!='') {
                    $this->titlePage = $item->getBasicInfo();
                    $this->metaDescription = $item->get('shortDescription');
                    $this->imagePage = $item->getImage('image', 'web');
                    $this->metaUrl = $item->url();
                    $this->breadCrumbs = array(url($this->action)=>__('categories'),
                                                $this->metaUrl=>$this->titlePage);
                    $this->content = $item->showUi('Complete');
                } else {
                    $this->titlePage = __('categories');
                    $this->metaUrl = url($this->action);
                    $this->breadCrumbs = array($this->metaUrl=>$this->titlePage);
                    $this->content = Category_Ui::intro();
                }
            break;
            case 'posts':
            case 'articles':
            case 'articulos':
                $item = Post::readFirst(array('where'=>'titleUrl="'.$this->id.'"'));
                $this->layoutPage = 'sidebar';
                if ($item->id()!='') {
                    $category = Category::read($item->get('idCategory'));
                    $this->titlePage = $item->getBasicInfo();
                    $this->metaDescription = $item->get('shortDescription');
                    $this->imagePage = $item->getImage('image', 'web');
                    $this->metaUrl = $item->url();
                    $this->breadCrumbs = array($category->url()=>$category->getBasicInfo(),
                                                $this->metaUrl=>$this->titlePage);
                    $this->content = $item->showUi('Complete');
                } else {
                    $this->titlePage = __('posts');
                    $this->metaUrl = url($this->action);
                    $this->breadCrumbs = array($this->metaUrl=>$this->titlePage);
                    $this->content = Post_Ui::intro();
                }
            break;
            case 'contact':
            case 'contacto':
                $page = Page::code($this->action);
                $this->titlePage = $page->getBasicInfo();
                $this->metaUrl = url($this->action);
                if ($this->id == 'thanks') {
                    $this->message = __('messageThanksContact');
                }
                if (count($this->values)>0) {
                    $form = new Contact_Form($this->values);
                    $errors = $form->isValid();
                    if (count($errors)>0) {
                        $this->content = Contact_Ui::intro(array('values'=>$this->values, 'errors'=>$errors));
                    } else {
                        $contact = new Contact();
                        $contact->insert($this->values);
                        HtmlMail::send(Params::param('email-contact'), 'notification', array('CONTENT'=>$contact->showUi('Email')));
                        header('Location: '.url($this->action.'/thanks'));
                        exit();
                    }
                } else {
                    $this->content = Contact_Ui::intro();
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