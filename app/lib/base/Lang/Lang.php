<?php
/**
* @class Lang
*
* This class represents a language for the website.
* It is used to manage the different translations.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Lang extends Db_Object {


    /**
    * Initialize the translations.
    */
    static public function init() {
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
    
    /**
    * Get the languages.
    */
    static public function langs() {
        if (!isset($_ENV['langs'])) {
            Lang::fillInfo();
        }
        return $_ENV['langs'];
    }

    /**
    * Get the language labels.
    */
    static public function langLabels() {
        if (!isset($_ENV['langLabels'])) {
            Lang::fillInfo();
        }
        return $_ENV['langLabels'];
    }

    /**
    * Fill the laguange code and labels into ENV variables.
    */
    static public function fillInfo() {
        $query = 'SELECT * FROM '.Db::prefixTable('Lang');
        $langIds = array();
        $result = Db::returnAll($query);
        foreach ($result as $item) {
            $langIds[] = $item['idLang'];
        }
        $_ENV['langs'] = $langIds;
        $_ENV['langLabels'] = $result;        
    }

    /**
    * Get the active language.
    */
    static public function active() {
        return Session::get('lang');
    }
    
    /**
    * Get the label of a language.
    */
    static public function getLabel($lang) {
        foreach (Lang::langLabels() as $langLabel) {
            if ($langLabel['idLang']==$lang) {
                return $langLabel['name'];
            }
        }
    }

    /**
    * Format the table field using the languages.
    */
    static public function field($field) {
        $result = '';
        foreach (Lang::langs() as $lang) {
            $result .= $field.'_'.$lang.',';
        }
        return substr($result, 0, -1);
    }

    /**
    * Initialize the table with default values.
    */
    static public function saveInitialValues() {
        $lang = new Lang();
        $lang->createTable();
        foreach (Lang::configLangs() as $code) {
            $lang = Lang::read($code);
            if ($lang->id()=='') {
                $lang->insert(array('idLang'=>$code, 'name'=>Lang::langCode($code)));
            }
        }
    }

    /**
    * Return the language label.
    */
    static public function langCode($code) {
        $langs = array('en'=>'English',
                        'fr'=>'Fran&ccedil;ais',
                        'es'=>'Espa&ntilde;ol');
        return (isset($langs[$code])) ? $langs[$code] : $code;
    }

    /**
    * Check the langs in the config file.
    */
    static public function configLangs() {
        return explode(':',LANGS);
    }
    
}
?>