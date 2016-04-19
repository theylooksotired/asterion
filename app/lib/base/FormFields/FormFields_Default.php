<?php
class FormFields_Default {

  protected $options;
  
  public function __construct($options) {
    $this->item = $options['item'];
    $this->name = (string)$this->item->name;
    $this->object = $options['object'];
    $this->values = isset($options['values']) ? $options['values'] : array();
    $this->errors = isset($options['errors']) ? $options['errors'] : array();
    $this->options = array();
    $nameMultiple = (isset($options['nameMultiple']) && isset($options['idMultiple']) && $options['nameMultiple']!='' && $options['idMultiple']!='');
    $this->options['name'] = ($nameMultiple) ? $options['nameMultiple'].'['.$options['idMultiple'].']['.$this->name.']' : $this->name;
    $this->options['value'] = $this->values[$this->name];
    $this->options['error'] = $this->errors[$this->name];
    $this->options['label'] = (string)$this->item->label;
    $this->options['placeholder'] = (string)$this->item->placeholder;
    $this->options['lang'] = (string)$this->item->lang;
    $this->options['layout'] = (string)$this->item->layout;
    $this->options['required'] = ((string)$this->item->required!='') ? true : false;
    $this->options['typeField'] = 'text';
  }

  public function show() {
    //Render a default input element
    if ((string)$this->item->lang == 'true') {
      $fields = '';
      $optionsName = $this->options['name'];
      foreach (Lang::langs() as $lang) {
        $nameLang = $this->name.'_'.$lang;
        $this->options['name'] = str_replace($this->name, $nameLang, $optionsName);
        $this->options['labelLang'] = Lang::getLabel($lang);
        $this->options['value'] = $this->values[$nameLang];
        $this->options['class'] = 'formField_'.$nameLang;
        $fields .= FormFields_Default::create($this->options);
      }
      return $fields;
    } else {
      return FormFields_Default::create($this->options);
    }
  }

  static public function create($options) {
    //Create a default input element
    $type = (isset($options['typeField'])) ? $options['typeField'] : 'text';
    $typeField = (isset($options['typeField'])) ? 'type="'.$options['typeField'].'"' : 'type="text"';
    $name = (isset($options['name'])) ? 'name="'.$options['name'].'" ' : '';
    $id = (isset($options['id'])) ? 'id="'.$options['id'].'"' : '';
    $labelLang = (isset($options['labelLang']) && $options['labelLang']!='') ? ' <span>('.$options['labelLang'].')</span>' : '';
    $label = (isset($options['label'])) ? '<label>'.__($options['label']).$labelLang.'</label>' : '';
    $value = (isset($options['value'])) ? 'value="'.$options['value'].'" ' : '';
    $disabled = (isset($options['disabled']) && $options['disabled']!=false) ? 'disabled="disabled"' : '';
    $size = (isset($options['size'])) ? 'size="'.$options['size'].'" ' : '';
    $error = (isset($options['error'])) ? '<div class="error">'.$options['error'].'</div>' : '';
    $class = (isset($options['class'])) ? $options['class'] : '';
    $classError = (isset($options['error']) && $options['error']!='') ? 'errorField' : '';
    $placeholder = (isset($options['placeholder'])) ? 'placeholder="'.__($options['placeholder']).'"' : '';
    $required = (isset($options['required']) && $options['required']) ? 'required' : '';
    //DELETE
    $required = '';
    //DELETE
    $layout = (isset($options['layout'])) ? $options['layout'] : '';
    switch ($layout) {
      default:
        return '<div class="'.$type.' formField '.$class.' '.$classError.'">
              <div class="formFieldIns">
                '.$label.'
                '.$error.'
                <input '.$typeField.' '.$name.' '.$size.' '.$value.' '.$id.' '.$disabled.' '.$placeholder.' '.$required.'/>
                <div class="clearer"></div>
              </div>
            </div>';
      break;
      case 'color':
        return '<div class="'.$type.' formField '.$class.' '.$classError.'">
              <div class="formFieldIns">
                '.$label.'
                '.$error.'
                <input class="color" '.$typeField.' '.$name.' '.$size.' '.$value.' '.$id.' '.$disabled.' '.$placeholder.' '.$required.'/>
                <div class="clearer"></div>
              </div>
            </div>';
      break;
      case 'simple':
        return '<input '.$typeField.' '.$name.' '.$size.' '.$value.' '.$id.' '.$disabled.' '.$placeholder.' class="'.$class.'"/>';
      break;
    }
  }
  
}
?>