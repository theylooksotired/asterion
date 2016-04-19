<?php
class FormFields_DefaultDate {

  protected $options;
  
  public function __construct($options) {
    $this->item = $options['item'];
    $this->name = (string)$this->item->name;
    $this->object = $options['object'];
    $this->values = isset($options['values']) ? $options['values'] : array();
    $this->errors = isset($options['errors']) ? $options['errors'] : array();
    $this->options = array();
    $nameMultiple = (isset($options['nameMultiple']) && isset($options['idMultiple']) && $options['nameMultiple']!='' && $options['idMultiple']);
    $this->options['nameMultiple'] = $nameMultiple;
    $this->options['name'] = $this->name;
    $this->options['name'] = ($nameMultiple) ? $options['nameMultiple'].'['.$options['idMultiple'].']['.$this->options['name'].']' : $this->options['name'];
    $this->options['error'] = $this->errors[$this->name];
    $this->options['label'] = (string)$this->item->label;
    $this->options['placeholder'] = (string)$this->item->placeholder;
    $this->options['checkboxDate'] = (string)$this->item->checkboxDate;
    $this->options['typeField'] = 'text';
    $this->options['value'] = (isset($this->values[$this->name]) && $this->values[$this->name]!='') ? $this->values[$this->name] : date('Y-m-d h:i');
  }
  
  public function show() {
    //Render a date element using selects
    return FormFields_DefaultDate::create($this->options);
  }

  static public function create($options) {
    $label = (isset($options['label'])) ? '<label>'.__($options['label']).'</label>' : '';
    $value = (isset($options['value'])) ? $options['value'] : '';
    $disabled = (isset($options['disabled'])) ? $options['disabled'] : '';
    $error = (isset($options['error'])) ? '<div class="error">'.$options['error'].'</div>' : '';
    $errorClass = (isset($options['error']) && $options['error']!='') ? 'errorField' : '';
    $class = (isset($options['class'])) ? $options['class'] : '';
    $layout = (isset($options['layout'])) ? $options['layout'] : '';
    $checkboxVal = ($value!='') ? "1" : "0";
    $checkbox = (isset($options['checkboxDate']) && $options['checkboxDate']=='true') ? FormFields_Checkbox::create(array('name'=>'check_'.$options['name'], 'value'=>$checkboxVal, 'class'=>'checkBoxInlineDate')) : '';
    $checkboxHidden = (isset($options['checkboxDate']) && $options['checkboxDate']=='true') ? FormFields_Hidden::create(array('name'=>'checkhidden_'.$options['name'], 'value'=>"1")) : '';
    $checkboxClass = (isset($options['checkboxDate']) && $options['checkboxDate'] == 'true') ? 'selectCheckbox' : '';
    return '<div class="select selectDate formField '.$class.' '.$errorClass.' '.$checkboxClass.'">
          '.$label.'
          '.$error.'
          <div class="selectIns">
            '.$checkbox.'
            '.$checkboxHidden.'
            '.FormFields_Date::createDate($options).'
            <div class="clearer"></div>
          </div>
        </div>';
  }

  public static function createComplete($options) {
    return FormFields_Date::createDate($options).'
        '.FormFields_Date::createTime($options);
  }

  public static function createDate($options) {
    $options['value'] = isset($options['value']) ? $options['value'] : date('Y-m-d h:i');
    $date = Date::sqlArray($options['value']);
    unset($options['label']);
    $view = (isset($options['view'])) ? $options['view'] : '';
    $options['layout'] = 'simple';
    $result = '';
    switch ($view) {
      default:
        $options['selected'] = $date['day'];
        $result .= FormFields_Date::createDay($options);
        $options['selected'] = $date['month'];
        $result .= FormFields_Date::createMonth($options);
        $options['selected'] = $date['year'];
        $result .= FormFields_Date::createYear($options);
      break;
      case 'hour':
        $options['selected'] = $date['hour'];
        $result .= FormFields_Date::createHour($options);
        $options['selected'] = $date['minutes'];
        $result .= FormFields_Date::createMinutes($options);
      break;
      case 'complete':
        $options['selected'] = $date['day'];
        $result = FormFields_Date::createDay($options);
        $options['selected'] = $date['month'];
        $result .= FormFields_Date::createMonth($options);
        $options['selected'] = $date['year'];
        $result .= FormFields_Date::createYear($options);
        $options['selected'] = $date['hour'];
        $result .= FormFields_Date::createHour($options);
        $options['selected'] = $date['minutes'];
        $result .= FormFields_Date::createMinutes($options);
      break;
      case 'year':
        $options['selected'] = $date['year'];
        $result .= FormFields_Date::createYear($options);
      break;
    }
    return $result;
  }
  
  public static function createTime($options) {
    $date = Date::sqlArray($options['value']);
    $options['selected'] = $date['hour'];
    $result = FormFields_Date::createHour($options);
    $options['selected'] = $date['minutes'];
    $result .= FormFields_Date::createMinutes($options);
    return $result;
  }
  
  public static function createDay($options) {
    $options['value'] = array_fillkeys(range(1, 31), range(1, 31));
    if ($options['nameMultiple']) {
      $options['name'] = (isset($options['name'])) ? substr($options['name'], 0, -1).'day]' : 'day';
    } else {    
      $options['name'] = (isset($options['name'])) ? $options['name'].'day' : 'day';
      $options['name'] = str_replace('[]day', 'day[]', $options['name']);
    }
    return FormFields_DefaultSelect::create($options);
  }
  
  public static function createMonth($options){
    $options['value'] = array_fillkeys(range(1, 12), range(1, 12));
    $options['value'] = Date::textMonthArray();
    if ($options['nameMultiple']) {
      $options['name'] = (isset($options['name'])) ? substr($options['name'], 0, -1).'mon]' : 'mon';
    } else {    
      $options['name'] = (isset($options['name'])) ? $options['name'].'mon' : 'mon';
      $options['name'] = str_replace('[]mon', 'mon[]', $options['name']);
    }
    return FormFields_DefaultSelect::create($options);
  }

  public static function createMonthSimple($options){
    $options['value'] = array_fillkeys(range(1, 12), range(1, 12));
    $options['value'] = Date::textMonthArraySimple();
    if ($options['nameMultiple']) {
      $options['name'] = (isset($options['name'])) ? substr($options['name'], 0, -1).'mon]' : 'mon';
    } else {    
      $options['name'] = (isset($options['name'])) ? $options['name'].'mon' : 'mon';
      $options['name'] = str_replace('[]mon', 'mon[]', $options['name']);
    }
    return FormFields_DefaultSelect::create($options);
  }
  
  public static function createYear($options){
    $fromYear = isset($options['fromYear']) ? $options['fromYear'] : date('Y')-90;
    $toYear = isset($options['toYear']) ? $options['toYear'] : date('Y')+20;
    $options['value'] = array_fillkeys(range($fromYear, $toYear), range($fromYear, $toYear));
    if ($options['nameMultiple']) {
      $options['name'] = (isset($options['name'])) ? substr($options['name'], 0, -1).'yea]' : 'yea';
    } else {    
      $options['name'] = (isset($options['name'])) ? $options['name'].'yea' : 'yea';
      $options['name'] = str_replace('[]yea', 'yea[]', $options['name']);
    }
    return FormFields_DefaultSelect::create($options);
  }
  
  public static function createHour($options){
    $options['value'] = array_fillkeys(range(0, 23), range(0, 23));
    foreach ($options['value'] as $key=>$value) {
      $options['value'][$key]=str_pad((string)$value, 2, "0", STR_PAD_LEFT);
    }
    if ($options['nameMultiple']) {
      $options['name'] = (isset($options['name'])) ? substr($options['name'], 0, -1).'hou]' : 'hou';
    } else {    
      $options['name'] = (isset($options['name'])) ? $options['name'].'hou' : 'hou';
      $options['name'] = str_replace('[]hou', 'hou[]', $options['name']);
    }
    return FormFields_DefaultSelect::create($options);
  }
  
  public static function createMinutes($options){
    $options['value'] = array_fillkeys(range(0, 59), range(0, 59));
    foreach ($options['value'] as $key=>$value) {
      $options['value'][$key]=str_pad((string)$value, 2, "0", STR_PAD_LEFT);
    }
    if ($options['nameMultiple']) {
      $options['name'] = (isset($options['name'])) ? substr($options['name'], 0, -1).'min]' : 'min';
    } else {    
      $options['name'] = (isset($options['name'])) ? $options['name'].'min' : 'min';
      $options['name'] = str_replace('[]min', 'min[]', $options['name']);
    }
    return FormFields_DefaultSelect::create($options);
  }

}
?>