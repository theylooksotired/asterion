<?php
class FormFields_Submit {

    protected $options;
    
    public function __construct($options) {
        $this->options = $options;
    }
    
    public function show() {
        //Render a submit input element
        return FormFields_Submit::create($this->options);
    }

    static public function create($options) {
        $name = (isset($options['name'])) ? 'name="'.$options['name'].'" ' : '';
        $id = (isset($options['id'])) ? 'id="'.$options['id'].'"' : '';
        $disabled = (isset($options['disabled'])) ? 'disabled="disabled"' : '';
        $value = (isset($options['value'])) ? 'value="'.$options['value'].'" ' : '';
        $class = (isset($options['class'])) ? $options['class'] : '';
        return '<div class="formSubmitWrapper">
                    <input type="submit" '.$name.' '.$value.' class="'.$class.'" '.$id.' '.$disabled.'/>
                </div>';
    }
    
}
?>