<?php
class FormFields_Radio extends FormFields_DefaultRadio {

    protected $options;
    
    public function __construct($options) {
        parent::__construct($options);
    }

    static public function create($options) {
        return FormFields_DefaultRadio::create($options);
    }

}
?>