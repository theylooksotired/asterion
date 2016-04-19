<?php
class FormFields_TextSmall extends FormFields_Text {

    protected $options;
    
    public function __construct($options) {
        parent::__construct($options);
        $this->options['size'] = 5;
    }

    static public function create($options) {
        $options['size'] = 5;
        return FormFields_Default::create($options);
    }
    
}
?>