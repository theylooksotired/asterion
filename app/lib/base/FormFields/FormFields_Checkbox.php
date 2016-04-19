<?php
class FormFields_Checkbox {

    protected $options;
    
    public function __construct($options) {
        $this->item = $options['item'];
        $this->name = (string)$this->item->name;
        $this->object = $options['object'];
        $this->values = isset($options['values']) ? $options['values'] : array();
        $this->errors = isset($options['errors']) ? $options['errors'] : array();
        $this->options = array();
        $nameMultiple = (isset($options['nameMultiple']) && isset($options['idMultiple']) && $options['nameMultiple']!='' && $options['idMultiple']);
        $this->options['name'] = $this->name;
        $this->options['name'] = ($nameMultiple) ? $options['nameMultiple'].'['.$options['idMultiple'].']['.$this->options['name'].']' : $this->options['name'];
        $this->options['value'] = $this->values[$this->name];
        $this->options['error'] = $this->errors[$this->name];
        $this->options['label'] = (string)$this->item->label;
        $this->options['placeholder'] = (string)$this->item->placeholder;
        $this->options['typeField'] = 'text';
    }

    public function show() {
        //Render a checkbox input element
        return FormFields_Checkbox::create($this->options);
    }
    
    static public function create($options) {
        //Render a checkbox element
        $name = (isset($options['name'])) ? 'name="'.$options['name'].'"' : '';
        $id = (isset($options['id'])) ? 'id="'.$options['id'].'" ' : '';
        $label = (isset($options['label'])) ? '<label>'.__($options['label']).'</label>' : '';
        $value = (isset($options['value']) && $options['value']=="1") ? 'checked="checked" ' : '';
        $disabled = (isset($options['disabled'])) ? 'disabled="disabled"' : '';
        $error = (isset($options['error'])) ? '<div class="error">'.$options['error'].'</div>' : '';
        $errorClass = (isset($options['error']) && $options['error']!='') ? 'errorField' : '';
        $class = (isset($options['class'])) ? $options['class'] : '';
        $layout = (isset($options['layout'])) ? $options['layout'] : '';
        $object = (isset($options['object'])) ? $options['object'] : '';
        switch ($layout) {
            default:
                return '<div class="checkbox formField '.$class.'">
                            '.$error.'
                            <div class="checkboxIns">
                                <input type="checkbox" '.$name.' '.$value.' '.$id.' '.$disabled.'/>
                                '.$label.'
                                <div class="clearer"></div>
                            </div>
                        </div>';
            break;
            case 'simple':
                return '<input type="checkbox" '.$name.' '.$value.' '.$id.' '.$disabled.'/>';
            break;
        }
    }

}
?>