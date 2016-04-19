<?php
class FormFields_Date extends FormFields_DefaultDate {

    protected $options;
    
    public function __construct($options) {
        parent::__construct($options);
    }

    static public function create($options) {
        return FormFields_DefaultDate::create($options);
    }
    
}
?>