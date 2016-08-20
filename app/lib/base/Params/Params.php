<?php
/**
* @class Params
*
* This class contains the parameters to run the website.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Params extends Db_Object {

    /**
    * Retrieve the values in the database and load them in memory.
    */
    static public function init() {
        $query = 'SELECT code, information
                    FROM '.Db::prefixTable('Params');
        $items = array();
        $result = Db::returnAll($query);
        foreach ($result as $item) {
            $items[$item['code']] = $item['information'];
        }
        $_ENV['params'] = $items;
    }

    /**
    * Get a parameter. The script also searches for the active language.
    */
    static public function param($code){
        if (isset($_ENV['params'][$code.'_'.Lang::active()])) {
            return $_ENV['params'][$code.'_'.Lang::active()];
        } else {
            return (isset($_ENV['params'][$code])) ? $_ENV['params'][$code] : '';
        }
    }

    /**
    * Load the initial parameters for the website.
    */
    static public function saveInitialValues() {
        $params = new Params();
        $params->createTable();
        $params = Params::countResults();
        if ($params == 0) {
            $itemsUrl = DATA_FILE.'Params.json';
            $items = json_decode(file_get_contents($itemsUrl), true);
            foreach (Lang::langs() as $lang) {
                $items[] = array('code'=>'titlePage_'.$lang, 'information'=>TITLE);
                $items[] = array('code'=>'metaDescription_'.$lang, 'information'=>TITLE.'...');
                $items[] = array('code'=>'metaKeywords_'.$lang, 'information'=>TITLE.'...');
            }
            $items[] = array('code'=>'email', 'information'=>EMAIL);
            foreach ($items as $item) {
                $itemSave = new Params();
                $itemSave->insert($item);
            }
        }
    }

}
?>