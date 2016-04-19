<?php
class LangTrans extends Db_Object {

    public function __construct($VALUES=array()) {
        parent::__construct($VALUES);
    }

    static public function translate($code) {
        //Return a translation using a code
        return isset($_ENV['lang'][$code]) ? $_ENV['lang'][$code] : $code;
    }

    static public function insertConfig() {
        //Initialize the table with default values
        $numTranslations = LangTrans::countResults();
        if ($numTranslations==0) {
            $items = LangTrans::basicCodes();
            foreach ($items as $item) {
                $langTrans = new LangTrans();
                $langTrans->insert($item);
            }
        }
    }

    static public function basicCodes() {
        //Default values in english, french and spanish
        return Csv::toArrays('LangTrans');
    }
    
}
?>