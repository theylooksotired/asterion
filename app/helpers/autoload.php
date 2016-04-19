<?php
function __autoload($className) {
    //Find the class in the model or framework and load it
    $objectName = $className;
    if (strpos($className, '_')!==false) {
        $class = explode('_', $className);
        $objectName = $class[0];
    }
    $addLocation = $objectName.'/'.$className.'.php';
    foreach ($_ENV['locations'] as $location) {
        if (is_file($location.$addLocation)) {
            require_once($location.$addLocation);
            return true;
        }
    }
    throw new Exception('Error on Autoload : the file for '.$className.' doesn\'t exists');
}
?>