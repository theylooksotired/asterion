<?php
/**
* @class FormFieldTextareaCk
*
* This is a helper class to generate a CK textarea form field.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class FormField_TextareaCk extends FormField_DefaultTextarea {

    /**
    * The constructor of the object.
    */
    public function __construct($options) {
        parent::__construct($options);
        $this->options['cols'] = 70;
        $this->options['rows'] = 10;
        $this->options['class'] = 'ckeditorArea';
    }

    /**
    * Render the element with an static function.
    */
    static public function create($options) {
        $options['cols'] = 70;
        $options['rows'] = 10;
        $options['class'] = 'ckeditorArea';
        return FormField_DefaultTextarea::create($options);
    }
    
}
?>