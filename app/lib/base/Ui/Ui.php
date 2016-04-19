<?php
class Ui {

    public function __construct ($object) {
        $this->object = $object;
    }
    
    public function renderPublic() {
        //Render a div with the basic information
        return '<div class="item item_'.$this->object->className.'">
                    '.$this->object->getBasicInfo().'
                </div>';
    }

    public function renderLink() {
        //Render a link
        return $this->object->link();
    }

    public function renderCsv() {
        //Render the simple information for a csv format
        return $this->object->getBasicInfo().',';
    }

    public function renderEmail() {
        //Render the object to send it within an email
        $content = '';
        foreach($this->object->info->attributes->attribute as $item) {
            $name = (string)$item->name;
            $label = (string)$item->form->label;
            switch((string)$item->form->type) {
                default:
                    $content .= '<strong>'.__($label).'</strong>: '.$this->object->get($name).'<br/>';
                break;
                case 'textarea':
                    $content .= '<strong>'.__($label).'</strong>: '.nl2br($this->object->get($name)).'<br/>';
                break;
                case 'textareaCK':
                    $content .= '<strong>'.__($label).'</strong>: '.html_entity_decode($this->object->get($name)).'<br/>';
                break;
                case 'select':
                case 'radio':
                    $content .= '<strong>'.__($label).'</strong>: '.$this->object->label($name).'<br/>';
                break;
                case 'date':
                case 'selectDate':
                    $content .= '<strong>'.__($label).'</strong>: '.Date::sqlText($this->object->get($name), true).'<br/>';
                break;
                case 'checkbox':
                    $value = ($this->object->get($name)==1) ? __('yes') : __('no');
                    $content .= '<strong>'.__($label).'</strong>: '.$value.'<br/>';
                break;
                case 'file':
                    if ((string)$item->form->fileType == 'image') {
                        $link = $this->object->getImageUrl($name);
                    } else {
                        $link = $this->object->getFileUrl($name);
                    }
                    if ($link!='') {
                        $content .= '<strong>'.__($label).'</strong>: <a href="'.$link.'" target="_blank">'.$link.'</a><br/>';
                    }
                break;
                case 'hidden':
                case 'password':
                break;
            }
        }
        return '<p>'.$content.'</p>';
    }
    
    public function renderAdmin($options=array()) {
        //Render the object for the admin area
        $userType = (isset($options['userType'])) ? $options['userType'] : '';
        $nested = (isset($options['nested']) && $options['nested']==true) ? true : false;
        $class = (isset($options['class'])) ? $options['class'] : '';
        $info = $this->object->info->info->form;
        $permissions = $info->permissions->$userType;
        $canModify = (is_object($permissions) && (string)$permissions->canModify == "true") ? $this->modify($nested) : '';
        $label = (is_object($permissions) && (string)$permissions->canModify == "true") ? $this->label(true, $nested) : $this->label(false, $nested);
        $canDelete = (is_object($permissions) && (string)$permissions->canDelete == "true") ? $this->delete() : '';
        $canOrder = (is_object($permissions) && (string)$permissions->canOrder == "true") ? $this->order() : '';
        $relOrd = (is_object($permissions) && (string)$permissions->canOrder == "true") ? 'rel="'.$this->object->id().'"' : '';
        $viewPublic = (is_object($permissions) && (string)$permissions->canView == "true") ? $this->view() : '';
        $layout = (string)$info->layout;
        $multipleChoice = '';
        if (isset($options['multipleChoice']) && $options['multipleChoice']==true) {
            $multipleChoice .= '<div class="checkboxAdmin">
                                    '.FormFields_Checkbox::create(array('name'=>$this->object->id())).'
                                </div>';
        }
        return '<div class="lineAdmin'.$this->object->className.' lineAdminLayout'.ucwords($layout).' lineAdmin '.$class.'" '.$relOrd.'>
                    <div class="lineAdminWrapper">
                        '.$multipleChoice.'
                        <div class="lineAdminOptions">
                            '.$viewPublic.'
                            '.$canDelete.'
                            '.$canModify.'
                            '.$canOrder.'
                        </div>
                        <div class="lineAdminLabel">
                            '.$label.'
                        </div>
                        <div class="clearer"></div>
                    </div>
                    <div class="modifySpace"></div>
                </div>';
    }
    
    public function renderSitemap($options=array()) {
        //Render the object as a sitemap url
        $changefreq = isset($options['changefreq']) ? $options['changefreq'] : 'weekly';
        $priority = isset($options['priority']) ? $options['priority'] : '1';
        $xml = '<url>
                    <loc>'.$this->object->url().'</loc>
                    <lastmod>'.date('Y-m-d').'</lastmod>
                    <changefreq>'.$changefreq.'</changefreq>
                    <priority>'.$priority.'</priority>
                </url>';
        return Text::minimize($xml);
    }

    public function renderRss($options=array()) {
        //Render the object as a sitemap url
        $xml = ' <item>
                        <title>'.$this->object->getBasicInfo().'</title>
                        <link>'.$this->object->url().'</link>
                        <description><![CDATA['.$this->object->get('description').']]></description>
                    </item>';
        return Text::minimize($xml);
    }

    public function renderForm($options=array()) {
        //Render a form for the object
        $nested = (isset($options['nested']) && $options['nested']==true) ? true : false;
        $values = (isset($options['values'])) ? $options['values'] : '';
        $action = (isset($options['action'])) ? $options['action'] : '';
        $class = (isset($options['class'])) ? $options['class'] : '';
        $submit = (isset($options['submit'])) ? $options['submit'] : __('save');
        $formClass = $this->object->className.'_Form';
        $objectForm = new $formClass;
        $form = $objectForm->newArray($values);
        return Form::createForm($form->createFormFields(false, $nested), array('action'=>$action, 'submit'=>$submit, 'class'=>$class, 'nested'=>$nested));
    }

    public function label($canModify=false, $nested=false) {
        //Create a label in the admin using the information in the XML file
        if (isset($this->object->info->info->form->labelAdmin->label)) {
            $labelSections = $this->object->info->info->form->labelAdmin->label;
            $html = '';
            foreach ($labelSections as $label) {
                $style = ((string)$label->attributes()->style != '') ? 'labelstyle_'.(string)$label->attributes()->style : '';
                if (count($label) > 0) {
                    $html .= '<div class="labelInsideWrapper '.$style.'">';
                    foreach ($label as $labelInside) {
                        $styleInside = ((string)$labelInside->attributes()->style != '') ? 'labelstyle_'.(string)$labelInside->attributes()->style : '';
                        $type = (string)$labelInside->attributes()->type;
                        $html .= $this->labelText($type, $styleInside, $labelInside, $canModify, $nested);
                    }
                    $html .= '</div>';                    
                } else {
                    $type = (string)$label->attributes()->type;
                    $html .= $this->labelText($type, $style, $label, $canModify, $nested);
                }
            }
            $html .= '<div class="clearer"></div>';
        } else {        
            $html = ($canModify) ? '<a href="'.$this->linkModify($nested).'">'.$this->object->getBasicInfoAdmin().'</a>' : $this->object->getBasicInfoAdmin();
        }
        return '<div class="label">
                    '.$html.'
                </div>';
    }

    public function labelText($type, $styleInside, $label, $canModify=false, $nested=false) {
        //Format the label text
        $labelText = ($type=="label" || $type=="labelLink") ? $this->object->decomposeText((string)$label, true) : $this->object->decomposeText((string)$label);
        $labelText = ($type=="date") ? Date::sqlText($labelText) : $labelText;
        $labelText = ($type=="dateSimple") ? Date::sqlDate($labelText) : $labelText;
        $labelText = ($type=="dayMonth") ? Date::sqlDayMonth($labelText) : $labelText;
        $labelText = ($type=="image" || $type=="imageLink") ? $this->object->getImage((string)$label, 'thumb') : $labelText;
        $labelText = ($type=="active") ? '<span class="activeItem activeItem_'.$this->object->decomposeText((string)$label).'"></span>' : $labelText;
        $labelHtml = ($canModify && ($type=="link" || $type=="imageLink" || $type=="labelLink")) ? '<a href="'.$this->linkModify($nested).'">'.$labelText.'</a>' : $labelText;
        $labelHtml = ($labelHtml == '') ? '&nbsp;' : $labelHtml;
        return '<div class="labelInside '.$styleInside.'">
                    '.$labelHtml.'
                </div>';
    }

    public function labelMultiple($objectName, $objectNameConnector, $separator=', ') {
        $objectNameIns = new $objectName();
        $query = 'SELECT DISTINCT o.*
                    FROM '.Db::prefixTable($objectName).' o
                    JOIN '.Db::prefixTable($objectNameConnector).' bo
                    ON (bo.'.$this->object->primary.'="'.$this->object->id().'" AND bo.'.$objectNameIns->primary.'=o.'.$objectNameIns->primary.')';
        $objects = $objectNameIns->readListQuery($query);
        $html = '';
        foreach ($objects as $object) {
            $html .= $object->getBasicInfo().$separator;
        }
        $html = substr($html, 0, -1 * strlen($separator));
        return $html;
    }

    public function linkModify($nested=false) {
        //Return the link for modification, in an admin context
        $link = ($nested) ? 'modifyViewNested' : 'modifyView';
        return url($this->object->className.'/'.$link.'/'.$this->object->id(), true);
    }

    public function linkDelete() {
        //Return the link for deletion, in an admin context
        return url($this->object->className.'/delete/'.$this->object->id(), true);
    }

    public function delete() {
        //Return a div with the delete link
        return '<div class="iconSide iconDelete">
                    <a href="'.$this->linkDelete().'">'.__('delete').'</a>
                </div>';
    }
    
    public function modify($nested=false) {
        //Return a div with the modify link
        return '<div class="iconSide iconModify">
                    <a href="'.$this->linkModify($nested).'">'.__('modify').'</a>
                </div>';
    }
    
    public function view() {
        //Return a div with the view public link
        return '<div class="iconSide iconView">
                    <a href="'.$this->object->url().'" target="_blank">'.__('view').'</a>
                </div>';
    }

    public function order() {
        //Return a div with the move handle
        return '<div class="iconSide iconHandle">
                    <span>'.__('move').'</span>
                </div>';
    }

}
?>