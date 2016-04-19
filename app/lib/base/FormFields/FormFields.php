<?php
class FormFields {

  static public function show($type, $options) {
    //A factory for the formfields
    $objectName = 'FormFields_'.str_replace(' ', '', ucwords(str_replace('-', ' ', $type)));
    $fileName = FRAMEWORK_FILE.'base/FormFields/'.$objectName.'.php';
    if (is_file($fileName)) {
      $field = new $objectName($options);
      return $field->show();
    } else {
      return 'The type '.$type.' is not valid';
    }
  }

}
?>