<?php
class Db_Object extends Db_Sql {

    public function __construct($values=array()) {
        $values = (is_array($values)) ? $values : array();
        parent::__construct($values);
        $this->syncValues($values);
        $this->loadedMultiple = false;
    }
    
    public function reloadObject() {
        $values = $this->readObjectValues($this->id());
        $this->syncValues($values);
    }

    public function syncValues($newValues=array()) {
        //Synchronize the values of an object
        if (isset($newValues[$this->primary]) && $newValues[$this->primary]=='') {
            unset($newValues[$this->primary]);
        }
        $values = (is_array($newValues)) ? array_merge($this->values, $newValues) : $this->values;
        foreach($this->info->attributes->attribute as $item) {
            $name = (string)$item->name;
            if ((string)$item->lang == 'true') {
                foreach (Lang::langs() as $lang) {
                    $keyLang = $name.'_'.$lang;
                    $this->values[$keyLang] = isset($values[$keyLang]) ? $values[$keyLang] : '';
                }
            } else {
                $this->values[$name] = isset($values[$name]) ? $values[$name] : '';
                if ((string)$item->type == 'point') {
                    if (isset($values[$name]) && $values[$name]!='') {
                        $infoPoint = explode(':', $values[$name]);
                        $this->values[$name.'_lat'] = (isset($infoPoint[0])) ? $infoPoint[0] : '';
                        $this->values[$name.'_lng'] = (isset($infoPoint[1])) ? $infoPoint[1] : '';
                    } else {
                        if (isset($values[$name.'_lat']) && $values[$name.'_lat']!='') {
                            $this->values[$name.'_lat'] = $values[$name.'_lat'];
                        }
                        if (isset($values[$name.'_lng']) && $values[$name.'_lng']!='') {
                            $this->values[$name.'_lng'] = $values[$name.'_lng'];
                        }
                    }
                }
            }
        }
    }

    public function loadMultipleValuesAll() {
        if ($this->loadedMultiple != true) {
            foreach($this->info->attributes->attribute as $item) {
                $type = (string)$item->type;
                if (Db_ObjectType::baseType($type) == 'multiple') {
                    $this->loadMultipleValues($item);
                }
            }
            $this->loadedMultiple = true;
        }
    }

    public function loadMultipleValues($item) {
        $name = (string)$item->name;
        $type = (string)$item->type;
        switch($type) {
            case 'multiple-object':
                $refObject = (string)$item->refObject;
                $lnkAttribute = (string)$item->lnkAttribute;
                $refObjectIns = new $refObject();
                $order = ($refObjectIns->hasOrd()) ? 'ord' : $refObjectIns->orderBy();
                $list = $refObjectIns->readListObject(array('where'=>Db::prefixTable($refObject).'.'.$lnkAttribute.'="'.$this->id().'"',
                                                            'completeList'=>false, 
                                                            'order'=>$order));
                $this->set($name, $list);
            break;
            case 'multiple-checkbox':
            case 'multiple-select':
            case 'multiple-autocomplete':
                $refObject = (string)$item->refObject;
                $refObjectIns = new $refObject();
                if ((string)$item->lnkObject!='') {                
                    $lnkObject = (string)$item->lnkObject;
                    $repeat = (string)$item->repeat;
                    $lnkObjectIns = new $lnkObject();
                    $lnkAttribute = $refObjectIns->primary;
                    $list = $lnkObjectIns->readListObject(array('object'=>$refObject,
                                                                'table'=>$lnkObject.','.$refObject,
                                                                'fields'=>Db::prefixTable($refObject).'.*',
                                                                'where'=>Db::prefixTable($refObject).'.'.$lnkAttribute.'='.Db::prefixTable($lnkObject).'.'.$lnkAttribute.'
                                                                        AND '.Db::prefixTable($lnkObject).'.'.$this->primary.'="'.$this->id().'"',
                                                                'completeList'=>false));
                } else {
                    $list = $refObjectIns->readListObject(array('where'=>$this->primary.'="'.$this->get($this->primary).'"',
                                                                'completeList'=>false));
                }
                $this->set($name, $list);
            break;
        }
    }

    //GETS
    public function id() {
        //Get the id of an object, defined in the XML final as "primary"
        return (isset($this->values[$this->primary])) ? $this->values[$this->primary] : '';
    }

    public function getBasicInfo() {
        //Gets the basic info of an object, normally this function should be overwritten for each object
        $label = (string)$this->info->info->form->label;
        if ($label != '') {
            return $this->decomposeText($label);
        } else {
            return $this->id();
        }
    }

    public function decomposeText($label) {
        $info = explode('_', $label);
        $result = '';
        foreach ($info as $item) {
            if (substr($item, 0, 1)=='#') {
                $result .= $this->get(substr($item, 1));
            } else {
                if (substr($item, 0, 1)=='?') {
                    $result .= __(substr($item, 1));
                } else {
                    $result .= $item;
                }
            }
        }
        return $result;
    }

    public function getBasicInfoAdmin() {
        //Gets the basic info of an object, used in the admin level
        return $this->getBasicInfo();
    }

    public function getBasicInfoAutocomplete() {
        //Gets the basic info of an object, used for the autocompletion inputs
        return $this->getBasicInfo();
    }

    public function getAttributes() {
        //Returns all the attributes information in the XML file
        return $this->info->attributes->attribute;
    }

    public function url() {
        //Gets the public url of an object based on the "idnav" and "base" values on the XML file, this function is usually overwritten for special urls in objects
        $idNav = (string)$this->info->info->nav->idnav;
        $base = (string)$this->info->info->nav->base;
        $nav = '';
        $idNavInfo = explode('_', $idNav);
        foreach ($idNavInfo as $idNavItem) {
            $nav .= $this->get($idNavItem).'_';
        }
        return url($base.'/'.substr($nav, 0, -1));
    }

    public function urlAdmin() {
        //Gets the url to modify an object in an admin level
        return url($this->className.'/modifyView/'.$this->id(), true);
    }

    public function link() {
        //Gets the html basic link of an object
        return '<a href="'.$this->url().'" title="'.$this->getBasicInfo().'">'.$this->getBasicInfo().'</a>';
    }

    public function linkNew() {
        //Gets the html basic link of an object
        return '<a href="'.$this->url().'" target="_blank" title="'.$this->getBasicInfo().'">'.$this->getBasicInfo().'</a>';
    }

    public function linkAdmin() {
        //Gets the html basic link of an object in an admin level
        return '<a href="'.$this->urlAdmin().'">'.$this->urlAdmin().'</a>';
    }

    public function valuesArray() {
        //Returns the values of the object
        return (is_array($this->values)) ? $this->values : array();
    }

    public function getValues($attribute, $admin=false) {
        //Gets all the values of the object
        $info = $this->attributeInfo($attribute);
        if (isset($info->refObject) && (string)$info->refObject != '') {
            $refObjectName = (string)$info->refObject;
            $refObject = new $refObjectName;
            return ($admin) ? $refObject->basicInfoAdminArray() : $refObject->basicInfoArray();
        } else {
            $values = (isset($info->values)) ? (array)$info->values : array();
            $result = array();
            if (isset($values['value']) && is_array($values['value'])) {
                foreach ($values['value'] as $key=>$value) {
                    $result[] = __($value);
                }                
            }
            return $result;
        }
    }

    public function basicInfoArray($options=array()) {
        //Returns an array with the basic information of a list of objects using the ids as keys
        $options = ($this->orderBy() != "") ? array_merge(array('order'=>$this->orderBy()), $options) : $options;
        $items = $this->readList($options);
        $result = array();
        foreach ($items as $item) {
            $result[$item->id()] = $item->getBasicInfo();
        }
        return $result;
    }

    public function basicInfoAdminArray($options=array()) {
        //Returns an array with the basic information of a list of objects using the ids as keys, in an admin level
        $orderAttribute = $this->orderBy();
        $order = '';
        if ($orderAttribute!='') {
            $orderInfo = $this->attributeInfo($orderAttribute);
            $order = (is_object($orderInfo) && (string)$orderInfo->lang == 'true') ? $orderAttribute.'_'.Lang::active() : $orderAttribute;
        }
        $options = ($order != "") ? array_merge(array('order'=>$order), $options) : $options;
        $items = $this->readList($options);
        $result = array();
        foreach ($items as $item) {
            $result[$item->id()] = $item->getBasicInfoAdmin();
        }
        return $result;
    }
    
    public function get($name) {
        //Gets the value of an attribute
        $nameLang = $name.'_'.Lang::active();
        $result = (isset($this->values[$name])) ? $this->values[$name] : '';
        $result = (isset($this->values[$nameLang])) ? $this->values[$nameLang] : $result;
        return $result;
    }

    public function attributeInfo($attribute) {
        //Gets the attribute information in the XML file
        $match = $this->info->xpath("/object/attributes/attribute//name[.='".$attribute."']/..");
        return (isset($match[0])) ? $match[0] : '';
    }

    public function attributeNames() {
        //Returns all the attribute names
        $list = array($this->primary, 'ord', 'created', 'modified');
        foreach($this->info->attributes->attribute as $item){
            $list[] = (string)$item->name;
        }
        return $list;
    }
    
    public function label($attribute, $admin=false) {
        //Gets the label of an attribute, it works for attributes as selects of multiple objects
        $info = $this->attributeInfo($attribute);
        if ((string)$info->type == 'autocomplete') {
            $refObject = (string)$info->form->refObject;
            $object = new $refObject;
            $object = $object->readObject($this->get($attribute));
            return ($admin) ? $object->getBasicInfoAdmin() : $object->getBasicInfo();
         } else {
            if ((string)$info->refObject != '') {
                $refObjectName = (string)$info->refObject;
                $refObject = new $refObjectName;
                $refObject = $refObject->readObject($this->get($attribute));
                return $refObject->getBasicInfo();
            } else {
                $values = $this->getValues($attribute, $admin);
                return (isset($values[$this->get($attribute)])) ? $values[$this->get($attribute)] : '';
            }
        }
    }

    public function getFileLink($attributeName) {
        //Gets the link to the file that the attribute points
        $file = $this->getFileUrl($attributeName);
        return ($file!='') ? '<a href="'.$file.'" target="_blank">'.__('viewFile').'</a>' : '';
    }

    public function getFileUrl($attributeName) {
        //Gets the url to the file that the attribute points
        $file = STOCK_URL.$this->className.'Files/'.$this->get($attributeName);
        return (is_file(str_replace(STOCK_URL, STOCK_FILE, $file))) ? $file : '';
    }

    public function getFile($attributeName) {
        //Gets the base to the file that the attribute points
        $file = STOCK_FILE.$this->className.'Files/'.$this->get($attributeName);
        return (is_file($file)) ? $file : '';
    }
    
    public function getImage($attributeName, $version='', $alternative='') {
        //Gets the html image that the attribute points
        $imageUrl = $this->getImageUrl($attributeName, $version);
        if ($imageUrl!='') {
            return '<img src="'.$imageUrl.'" alt="'.$this->getBasicInfo().'"/>';
        } else {
            return $alternative;
        }
    }

    public function getImageUrl($attributeName, $version='') {
        //Gets the url of an image that the attribute points
        $version = ($version != '') ? '_'.strtolower($version) : '';
        $file = STOCK_FILE.$this->className.'/'.$this->get($attributeName).'/'.$this->get($attributeName).$version.'.jpg';
        if (is_file($file)) {
            return str_replace(STOCK_FILE, STOCK_URL, $file);
        }
    }

    public function orderBy() {
        return (string)$this->info->info->form->orderBy;
    }

    //SETS
    public function setId($id) {
        //Sets the id of an object
        $this->values[$this->primary] = $id;
    }

    public function set($name, $value='') {
        //Sets a value to an attribute of an object
        if (is_array($name)) {
            foreach ($name as $key=>$item) {
                $this->set($key,$item);
            }
        } else {
            $this->values[$name] = $value;
        }
    }

    //HAS
    public function hasCreated() {
        return ((string)$this->info->info->sql->created == 'true');
    }

    public function hasModified() {
        return ((string)$this->info->info->sql->modified == 'true');
    }

    public function hasOrd() {
        return ((string)$this->info->info->sql->order == 'true');
    }

    public function hasIdAutoIncrement() {
        if (!is_object($this->attributeInfo($this->primary))) {
            return false;
        }
        return ((string)$this->attributeInfo($this->primary)->type == 'id-autoincrement');
    }

    //UI
    public function showUi($functionName, $params=array()) {
        //Creates an instance of the UIHtml object and returns a function to render
        $uiObjectName = $this->className.'_Ui';
        $uiObject = new $uiObjectName($this);
        $render = 'render'.ucwords($functionName);
        return $uiObject->$render($params);
    }
    
}
?>