<?php
class FormFields_TextareaCk extends FormFields_DefaultTextarea {

    protected $options;
    
    public function __construct($options) {
        parent::__construct($options);
        $this->options['cols'] = 70;
        $this->options['rows'] = 10;
        $this->options['class'] = 'ckeditorArea';
    }

    static public function create($options) {
        $options['cols'] = 70;
        $options['rows'] = 10;
        $options['class'] = 'ckeditorArea';
        return FormFields_DefaultTextarea::create($options);
    }
    
}
?>