<?php
/**
* @class Init
*
* This class contains static functions to initialize the website.
* It is only called in DEBUG mode and it helps to setup Asterion for the first time.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Init {
    
    /**
    * Main function to initialize the website.
    */
    static public function initSite(){
        Lang::saveInitialValues();
        Params::saveInitialValues();
        if (DEBUG) {
            $objectNames = File::scanDirectoryObjects();
            foreach ($objectNames as $objectName) {
                $options = ($objectName == 'User') ? array('EMAIL'=>EMAIL) : array();
                Init::saveInitialValues($objectName, $options);
            }
        }
    }

    /**
    * Load the initial values at the time of installation
    * and save them in the database.
    */
    static public function saveInitialValues($className, $extraValues=array()) {
        $object = new $className;
        $object->createTable();
        $numberItems = $object->countResults();
        $dataUrl = DATA_FILE.$className.'.json';
        if (!file_exists($dataUrl)) {
            $dataUrl = DATA_LOCAL_FILE.$className.'.json';
        }
        if (file_exists($dataUrl) && $numberItems==0) {
            $items = json_decode(file_get_contents($dataUrl), true);
            foreach ($items as $item) {
                $itemSave = new $className;
                if (count($extraValues) > 0) {
                    foreach ($extraValues as $keyExtraValue=>$itemExtraValue) {
                        foreach ($item as $keyItem=>$eleItem) {
                            $item[$keyItem] = str_replace('##'.$keyExtraValue, $itemExtraValue, $eleItem);
                        }
                    }
                }
                $itemSave->insert($item);
            }
        }
    }

}
?>