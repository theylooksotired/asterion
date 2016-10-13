<?php
/**
* @class MenuItemForm
*
* This class manages the forms for the MenuItem objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class MenuItem_Form extends Form {

    /**
    * Overwrite the createFormFields function.
    */
    public function createFormFields($options=array()) {
        $html = '';
        $options['multiple'] = (isset($options['multiple']) && $options['multiple']) ? true : false;
        $options['idMultiple'] = ($options['multiple']) ? md5(rand()*rand()*rand()) : '';
        $options['idMultiple'] = (isset($options['idMultipleJs']) && $options['idMultipleJs']!='') ? $options['idMultipleJs'] : $options['idMultiple'];
        $options['nameMultiple'] = (isset($options['nameMultiple'])) ? $options['nameMultiple'] : '';
        if ($this->object->hasOrd()) {
            $nameOrd = ($options['nameMultiple']!='') ? $options['nameMultiple'].'['.$options['idMultiple'].'][ord]' : 'ord';
            $html .= FormField_Hidden::create(array_merge(array('name'=>$nameOrd, 'value'=>$this->object->get('ord'), 'class'=>'fieldOrd'), $options));
        }
        $valuesSubmenu = array();
        $itemsSubmenu = Menu::readList(array('where'=>'idMenu!="'.$this->values['idMenu'].'"', 'order'=>'name_'.Lang::active()));
        foreach ($itemsSubmenu as $itemSubmenu) {
        	$valuesSubmenu[$itemSubmenu->id()] = $itemSubmenu->getBasicInfoAdmin();
        }
        $select = $this->field('link', $options);
        $switchValue = 'external';
        $content = $this->field('label', $options).'
                '.$this->field('externalLink', $options);
        $html .= $this->field('idMenuItem', $options).'
                '.$this->field('idMenu', $options).'
                '.Helper::accordionSelect($select, $switchValue, $content).'
                '.$this->field('idSubMenu', array_merge($options, array('value'=>$valuesSubmenu)));
        return $html;
    }

}
?>