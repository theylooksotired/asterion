<?php
class FormFields_Select extends FormFields_DefaultSelect {

    protected $options;
    
    public function __construct($options) {
        parent::__construct($options);
    }

    static public function create($options) {
        return FormFields_DefaultSelect::create($options);
    }

}
?>