<?php
class Controller_Factory {

    static function factory($GET=array(), $POST=array(), $FILES=array()) {
        //Get the right controller for the object
        $type = (isset($GET['type'])) ? $GET['type'] : '';
        $objectController = $type.'_Controller';
        $addLocation = $type.'/'.$objectController.'.php';
        foreach ($_ENV['locations'] as $location) {
            if (is_file($location.$addLocation)) {
                return new $objectController($GET, $POST, $FILES);
            }    
        }
        throw new Exception('Could not load controller '.$type);
    }

}
?>