<?php
class Navigation_Ui extends Ui {

    public function render() {
        $layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
        $title = (isset($this->object->titlePage)) ? '<h1>'.$this->object->titlePage.'</h1>' : '';
        $message = (isset($this->object->message)) ? '<div class="message">'.$this->object->message.'</div>' : '';
        $messageError = (isset($this->object->messageError)) ? '<div class="message messageError">'.$this->object->messageError.'</div>' : '';
        $content = (isset($this->object->content)) ? $this->object->content : '';
        switch ($layoutPage) {
            default:
                return '<div class="contentWrapper">
                            '.$this->header().'
                            '.$this->menu().'
                            <div class="content">'.$content.'</div>
                            '.$this->footer().'
                        </div>';
            break;
        }
    }

    public function header() {
        return '<div class="header">
                    <div class="headerIns">
                        <div class="headerLeft">
                            <div class="logo">
                                <a href="'.url('').'">'.Params::param('titlePage').'</a>
                            </div>
                        </div>
                        <div class="headerRight">
                            <div class="headerRightTop">
                                '.Lang_Ui::showLangs(true).'
                                '.$this->shareIcons().'
                            </div>
                            <div class="headerRightBottom">
                                '.$this->search().'
                            </div>
                        </div>
                    </div>
                </div>';
    }

    public function footer() {
        return '<footer class="footer">
                    <div class="footerIns">'.HtmlSection::show('footer').'</div>
                </footer>';
    }

    public function shareIcons() {
        $html = '';
        foreach (Params::paramsList() as $code=>$param) {
            if (strpos($code, 'linksocial-')!==false) {
                $code = str_replace('linksocial-', '', $code);
                $html .= '<div class="shareIcon shareIcon-'.$code.'">
                            <a href="'.Url::format($param).'" target="_blank">'.$code.'</a>
                        </div>';
            }
        }
        return ($html!='') ? '<div class="shareIcons">'.$html.'</div>' : '';
    }

    public function menu() {
        return Menu::show('main');
        return '<nav class="menu">
                    <div class="menuIns">
                        <div class="menuItem">
                            <a href="">Menu item 1</a>
                        </div>
                        <div class="menuItem">
                            <a href="">Menu item 2</a>
                        </div>
                        <div class="menuItem">
                            <a href="">Menu item 3</a>
                        </div>
                        <div class="menuItem">
                            <a href="">Menu item 4</a>
                        </div>
                        <div class="menuItem">
                            <a href="">Menu item 5</a>
                        </div>
                        <div class="menuItem">
                            <a href="">Menu item 6</a>
                        </div>
                    </div>
                </nav>';
    }

    public function search() {
        $field = FormField::create('text', array('name'=>'search', 'placeholder'=>__('search')));
        return '<div class="searchTop">
                    '.Form::createForm($field, array('submit'=>'ajax', 'class'=>'formSearch')).'
                </div>';
    }

}
?>