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
                            <div class="contentTop">
                                '.$this->header().'
                            </div>
                            <div class="content">
                                '.$message.'
                                '.$messageError.'
                                <div class="contentIns">
                                    '.$this->breadCrumbs().'
                                    '.$title.'
                                    '.$content.'
                                </div>
                            </div>
                            '.$this->footer().'
                        </div>';
            break;
            case 'documentation':
                return '<div class="contentWrapper contentWrapperDocumentation">
                            <div class="contentTop">
                                '.$this->header().'
                            </div>
                            <div class="content">
                                '.$message.'
                                '.$messageError.'
                                <div class="contentIns">
                                    '.$this->breadCrumbs().'
                                    '.$title.'
                                    '.$content.'
                                </div>
                            </div>
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
                                <a href="'.url('').'">'.Params::param('metainfo-titlePage').'</a>
                            </div>
                        </div>
                        <div class="headerRight">
                            '.$this->menu().'
                        </div>
                    </div>
                </div>';
    }

    public function footer() {
        return '<footer class="footer">
                    <div class="footerIns">
                        '.HtmlSection::show('footer').'
                    </div>
                </footer>';
    }

    public function menu() {
        return '<nav class="menu">
                    <div class="menuIns">
                        <div class="menuItem">
                            <a href="'.url('documentation').'">'.__('documentation').'</a>
                        </div>
                        <div class="menuItem">
                            <a href="'.url('portfolio').'">'.__('portfolio').'</a>
                        </div>
                        <div class="menuItem">
                            <a href="'.url('about-us').'">'.__('about-us').'</a>
                        </div>
                        <div class="menuItem">
                            <a href="'.url('github').'">GitHub</a>
                        </div>
                    </div>
                </nav>';
    }

    public function sidebar() {
        return '<aside class="sidebar">
                    <div class="sidebarIns">
                        <div class="sidebarBlock">'.Post_Ui::latest().'</div>
                        <div class="sidebarBlock">'.Post_Ui::popular().'</div>
                    </div>
                </aside>';
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

    public function search() {
        $field = FormField::create('text', array('name'=>'search', 'placeholder'=>__('search')));
        return '<div class="searchTop">
                    '.Form::createForm($field, array('submit'=>'ajax', 'class'=>'formSearch')).'
                </div>';
    }

    public function breadCrumbs() {
        $html = '';
        if (isset($this->object->breadCrumbs) && is_array($this->object->breadCrumbs)) {
            $html .= '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a href="'.url('').'" itemprop="item">
                            <span itemprop="name">'.__('homePage').'</span>
                        </a>
                    </span>';
            foreach ($this->object->breadCrumbs as $url=>$title) {
                $html .= '<span class="breadCrumbSeparator">&raquo;</span>
                            <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a href="'.$url.'" itemprop="item">
                                    <span itemprop="name">'.$title.'</span>
                                </a>
                            </span>';
            }
            $html = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'.$html.'</div>';
        }
        return $html;
    }

}
?>