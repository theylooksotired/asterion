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
                            '.$this->shareIcons().'
                            '.$this->search().'
                        </div>
                    </div>
                </div>';
    }

    public function footer() {
        return '<div class="footer">
                    <div class="footerIns">
                        <p>Here goes the footer</p>
                    </div>
                </div>';
    }

    public function shareIcons() {
        return '<div class="shareIcons">
                    <div class="shareIcon shareIconFacebook">
                        <a href="'.Url::format(Params::param('link-facebook')).'" target="_blank">Facebook</a>
                    </div>
                    <div class="shareIcon shareIconTwitter">
                        <a href="'.Url::format(Params::param('link-twitter')).'" target="_blank">Twitter</a>
                    </div>
                    <div class="shareIcon shareIconYoutube">
                        <a href="'.Url::format(Params::param('link-youtube')).'" target="_blank">Youtube</a>
                    </div>
                    <div class="shareIcon shareIconLinkedIn">
                        <a href="'.Url::format(Params::param('link-linkedin')).'" target="_blank">LinkedIn</a>
                    </div>
                </div>';
    }

    public function menu() {
        return '<div class="menu">
                    <div class="menuIns">
                        <a href="">Menu item 1</a>
                    </div>
                    <div class="menuIns">
                        <a href="">Menu item 2</a>
                    </div>
                    <div class="menuIns">
                        <a href="">Menu item 3</a>
                    </div>
                </div>';
    }

    public function search() {
        $field = FormField::create('text', array('name'=>'search'));
        return '<div class="searchTop">
                    '.Form::createForm($field, array('submit'=>__('search'), 'class'=>'formSearch')).'
                </div>';
    }

}
?>