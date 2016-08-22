<?php
/**
* @class FormField
*
* This is a helper class that is used as a factory to load a form field object.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class FormField {

    /**
    * A factory function to show the formfields
    */
    static public function show($type, $options) {
        $objectName = 'FormField_'.str_replace(' ', '', ucwords(str_replace('-', ' ', $type)));
        $fileName = FRAMEWORK_FILE.'base/FormField/'.$objectName.'.php';
        if (is_file($fileName)) {
            $field = new $objectName($options);
            return $field->show();
        } else {
            return 'The type '.$type.' is not valid';
        }
    }

}
?>