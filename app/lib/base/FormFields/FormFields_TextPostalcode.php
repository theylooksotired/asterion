<?php
class FormFields_TextPostalcode extends FormFields_Text {

    protected $options;
    
    public function __construct($options) {
        parent::__construct($options);
        $this->options['size'] = 7;
    }

    static public function create($options) {
        $options['size'] = 7;
        return FormFields_Default::create($options);
    }
    
}
?>