<?php
class NavigationAdmin_Ui extends Ui{

    public function render() {
        //Render the page using different layouts
        $layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
        $title = (isset($this->object->titlePage)) ? '<h1>'.$this->object->titlePage.'</h1>' : '';
        $message = (isset($this->object->message)) ? '<div class="message">'.$this->object->message.'</div>' : '';
        $messageError = (isset($this->object->messageError)) ? '<div class="message messageError">'.$this->object->messageError.'</div>' : '';
        $menuInside = (isset($this->object->menuInside)) ? $this->object->menuInside : '';
        $content = (isset($this->object->content)) ? $this->object->content : '';
        switch ($layoutPage) {
            default:
                return '<div class="contentWrapper">
                            '.$this->renderHeader().'
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
                                        '.$this->renderFooter().'
                                    </div>
                                </div>
                                <div class="clearer"></div>
                            </div>
                        </div>';
            break;
            case 'simple':
                return '<div class="contentWrapper">
                            '.$this->renderHeader().'
                            <div class="contentSimple">
                                '.$title.'
                                '.$messageError.'
                                '.$message.'
                                '.$content.'
                                '.$this->renderFooter().'
                            </div>
                        </div>';
            break;
        }
    }

    public function renderHeader() {
        //Render the header for the page
        return '<div class="headerWrapper">
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
                        <div class="clearer"></div>
                    </div>
                </div>';
    }

    public function renderFooter() {
        //Render the footer for the page
        return '<div class="footer">
                    '.HtmlSectionAdmin::show('footer').'
                </div>';
    }

    public function renderMenu() {
        //Render the menu for the page based on the user type
        $login = User_Login::getInstance();
        $userType = UserType::readFirst(array('where'=>'code="'.$login->get('type').'"'));
        if ($userType->id()!='') {
            $menuList = new ListObjects('UserTypeMenu', array('where'=>'idUserType="'.$userType->id().'"', 'order'=>'ord'));
            return '<div class="menuSide">
                        '.$menuList->showList(array('function'=>'Menu')).'
                    </div>';
        }
    }

}
?>