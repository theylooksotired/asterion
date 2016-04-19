<?php
class Lang extends Db_Object {

  public function __construct($values=array()) {
    parent::__construct($values);
  }

  static public function init() {
    //Initialize the translations
    if (isset($_GET['lang'])) {
      $configLangs = Lang::configLangs();
      if (count($configLangs)>1) {
        $lang = Lang::read($_GET['lang']);
        if ($lang->id()=='') {
          $lang = Lang::readFirst(array('order'=>'ord'));
        }
        Session::set('lang', $lang->id());
      } else {
        Session::set('lang', $configLangs[0]);
      }
      $query = 'SELECT code, translation_'.Session::get('lang').' as translation
              FROM '.Db::prefixTable('LangTrans');
      $items = array();
      $result = Db::returnAll($query);
      foreach ($result as $item) {
        $items[$item['code']] = $item['translation'];
      }
      $_ENV['lang'] = $items;
    }
  }
  
  static public function langs() {
    //Get the languages
    if (!isset($_ENV['langs'])) {
      Lang::fillInfo();
    }
    return $_ENV['langs'];
  }

  static public function langLabels() {
    //Get the language labels
    if (!isset($_ENV['langLabels'])) {
      Lang::fillInfo();
    }
    return $_ENV['langLabels'];
  }

  static public function fillInfo() {
    //Fill the laguange code and labels into ENV variables
    $query = 'SELECT * FROM '.Db::prefixTable('Lang');
    $langIds = array();
    $result = Db::returnAll($query);
    foreach ($result as $item) {
      $langIds[] = $item['idLang'];
    }
    $_ENV['langs'] = $langIds;
    $_ENV['langLabels'] = $result;    
  }

  static public function active() {
    //Get the active language
    return Session::get('lang');
  }
  
  static public function getLabel($lang) {
    //Get the label of a language
    foreach (Lang::langLabels() as $langLabel) {
      if ($langLabel['idLang']==$lang) {
        return $langLabel['name'];
      }
    }
  }

  static public function field($field) {
    //Format the table field using the langs
    $result = '';
    foreach (Lang::langs() as $lang) {
      $result .= $field.'_'.$lang.',';
    }
    return substr($result, 0, -1);
  }

  static public function insertConfig() {
    //Initialize the table with default values
    foreach (Lang::configLangs() as $code) {
      $lang = Lang::read($code);
      if ($lang->id()=='') {
        $lang->insert(array('idLang'=>$code, 'name'=>Lang::langCode($code)));
      }
    }
  }

  static public function langCode($code) {
    //Return the language label
    $langs = array('en'=>'English',
            'fr'=>'Fran&ccedil;ais',
            'es'=>'Espa&ntilde;ol');
    return (isset($langs[$code])) ? $langs[$code] : $code;
  }

  static public function configLangs() {
    //Check the langs in the config file
    return explode(':',LANGS);
  }
  
}
?>