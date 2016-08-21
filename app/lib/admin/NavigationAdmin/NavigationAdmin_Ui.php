<?php
/**
* @class NavigationAdmin_Ui
*
* This class manages the UI for the NavigationAdmin object.
* Here we render the template for the administration area.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class NavigationAdmin_Ui extends Ui{

    /**
    * Render the page using different layouts
    */
    public function render() {
        $layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
        $title = (isset($this->object->titlePage) && $this->object->titlePage!='') ? '<h1>'.$this->object->titlePage.'</h1>' : '';
        $message = (isset($this->object->message) && $this->object->message!='') ? '<div class="message">'.$this->object->message.'</div>' : '';
        $messageError = (isset($this->object->messageError) && $this->object->messageError!='') ? '<div class="message messageError">'.$this->object->messageError.'</div>' : '';
        $menuInside = (isset($this->object->menuInside)) ? $this->object->menuInside : '';
        $content = (isset($this->object->content)) ? $this->object->content : '';
        switch ($layoutPage) {
            default:
                return '<div class="contentWrapper">
                            '.$this->header().'
                            <div class="contentIns">
                                <div class="contentMenu">
                                    '.$this->renderMenu().'
                                </div>
                                <div class="contentInsWrapper">
                                    <div class="content">
                                        <div class="contentTop">
                                            <div class="contentTopLeft">
                                                '.$title.'
                                            </div>
                                            <div class="contentTopRight">
                                                '.$menuInside.'
                                            </div>
                                            <div class="clearer"></div>
                                        </div>
                                        '.$messageError.'
                                        '.$message.'
                                        '.$content.'
                                        '.$this->footer().'
                                    </div>
                                </div>
                                <div class="clearer"></div>
                            </div>
                        </div>';
            break;
            case 'simple':
                return '<div class="contentWrapper">
                            '.$this->header().'
                            <div class="contentSimple">
                                '.$title.'
                                '.$messageError.'
                                '.$message.'
                                '.$content.'
                                '.$this->footer().'
                            </div>
                        </div>';
            break;
        }
    }

    /**
    * Render the header for the page
    */
    public function header() {
        return '<header class="headerWrapper">
                    <div class="headerIns">
                        <div class="headerLeft">
                            <div class="logo">
                                <a href="'.url('', true).'">'.Params::param('titlePage').'</a>
                            </div>
                        </div>
                        <div class="headerRight">
                            '.Lang_Ui::showLangs(true).'
                            '.User_Ui::infoHtml().'
                        </div>
                    </div>
                </header>';
    }

    /**
    * Render the footer for the page
    */
    public function footer() {
        return '<footer class="footer">
                    '.HtmlSectionAdmin::show('footer').'
                </footer>';
    }

    /**
    * Render the menu for the page based on the user type
    */
    public function renderMenu() {
        $login = User_Login::getInstance();
        $userType = UserType::read($login->get('idUserType'));
        if ($userType->id()!='') {
            $menuList = new ListObjects('UserTypeMenu', array('where'=>'idUserType="'.$userType->id().'"', 'order'=>'ord'));
            $permissionMenuItem = '';
            if ($userType->get('managesPermissions')=='1') {
                $permissionMenuItem = '<div class="menuSideItem menuSideItem-2">
                                            <a href="'.url('Permission', true).'">'.__('permissions').'</a>
                                        </div>';
            }
            return '<nav class="menuSide">
                        '.$menuList->showList(array('function'=>'Menu')).'
                        '.$permissionMenuItem.'
                        <div class="menuSideItem menuSideItem-3">
                            <a href="'.url('User/logout', true).'">'.__('logout').'</a>
                        </div>
                    </nav>';
        }
    }

}
?>