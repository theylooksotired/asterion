<?php
class FormFields_DateYear extends FormFields_DefaultDate {

    protected $options;
    
    public function __construct($options) {
        parent::__construct($options);
        $this->options['view'] = 'year';
    }

    static public function create($options) {
        $options['view'] = 'year';
        return FormFields_DefaultDate::create($options);
    }
    
}
?>