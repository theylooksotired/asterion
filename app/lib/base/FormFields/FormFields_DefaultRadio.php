<?php
class FormFields_DefaultRadio {

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
        $this->options['error'] = $this->errors[$this->name];
        $this->options['label'] = (string)$this->item->label;
        $this->options['placeholder'] = (string)$this->item->placeholder;
        $this->options['typeField'] = 'text';
        //Load the values
        $refObject = (string)$this->item->refObject;
        if ($refObject != "") {
            $refObjectIns = new $refObject();
            $this->options['value'] = $refObjectIns->basicInfoAdminArray();
        } else {
            $choicesArray = (array)$this->item->values;
            $this->options['value'] = $choicesArray['value'];
        }
        //Load the selected values
        $this->options['selected'] = $this->values[$this->name];
    }

    public function show() {
        //Render a default input element
        return FormFields_Radio::create($this->options);
    }

    static public function create($options) {
        //Create a default input element
        $typeField = (isset($options['typeField'])) ? 'type="'.$options['typeField'].'" ' : 'type="text"';
        $name = (isset($options['name'])) ? 'name="'.$options['name'].'" ' : '';
        $nameRadio = (isset($options['name'])) ? $options['name'] : '';
        $id = (isset($options['id'])) ? 'id="'.$options['id'].'"' : '';
        $label = (isset($options['label'])) ? '<label>'.__($options['label']).'</label>' : '';
        $value = (isset($options['value'])) ? $options['value'] : '';
        $selected = (isset($options['selected'])) ? $options['selected'] : '';
        $disabled = (isset($options['disabled']) && $options['disabled']!=false) ? 'disabled="disabled"' : '';
        $multiple = (isset($options['multiple'])) ? 'multiple="multiple"' : '';
        $checkboxValue = ($selected!='') ? 1 : 0;
        $checkbox = (isset($options['checkbox']) && $options['checkbox']!=false) ? FormFields_Checkbox::create(array('name'=>$options['name'].'_checkbox', 'value'=>$checkboxValue, 'class'=>'checkBoxInline')) : '';
        $classCheckbox = (isset($options['checkbox']) && $options['checkbox']!=false) ? 'selectCheckbox' : '';
        $size = (isset($options['size'])) ? 'size="'.$options['size'].'" ' : '';
        $error = (isset($options['error'])) ? '<div class="error">'.$options['error'].'</div>' : '';
        $class = (isset($options['class'])) ? $options['class'] : '';
        $errorClass = (isset($options['error']) && $options['error']!='') ? 'errorField' : '';
        $placeholder = (isset($options['placeholder'])) ? 'placeholder="'.__($options['placeholder']).'"' : '';
        $layout = (isset($options['layout'])) ? $options['layout'] : '';
        $htmlOptions = '';
        if (is_array($value)) {
            foreach ($value as $key=>$item) {
                $isSelected = ($key==$selected || (is_array($selected) && in_array($key, $selected))) ? 'checked="checked"' : '';
                $htmlOptions .= '<div class="radioValue">
                                    <input type="radio" '.$name.' class="radioItem_'.$key.'" value="'.$key.'" '.$isSelected.'/>
                                    <label for="'.$key.'">'.__($item).'</label>
                                    <div class="clearer"></div>
                                </div>';
            }
        }
        switch ($layout) {
            default:
                return '<div class="radio formField '.$class.' '.$classCheckbox.' '.$errorClass.'">
                            <div class="formFieldIns">
                                '.$label.'
                                '.$error.'
                                '.$htmlOptions.'
                                <div class="clearer"></div>
                            </div>
                        </div>';
            break;
            case 'simple':
                return $checkbox.$htmlOptions;
            break;
        }
    }
    
}
?>