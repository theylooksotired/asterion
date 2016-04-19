<?php
if(!function_exists('get_called_class')) {
    function get_called_class($bt = false,$l = 1) {
        //Find called class
        if (!$bt) $bt = debug_backtrace();
        if (!isset($bt[$l])) throw new Exception("Cannot find called class -> stack level too deep.");
        if (!isset($bt[$l]['type'])) {
            throw new Exception ('type not set');
        }
        else switch ($bt[$l]['type']) {
            case '::':
                $lines = file($bt[$l]['file']);
                $i = 0;
                $callerLine = '';
                do {
                    $i++;
                    $callerLine = $lines[$bt[$l]['line']-$i] . $callerLine;
                } while (strpos($callerLine,$bt[$l]['function']) === false);
                preg_match('/([a-zA-Z0-9\_]+)::'.$bt[$l]['function'].'/',
                            $callerLine,
                            $matches);
                if (!isset($matches[1])) {
                    throw new Exception ("Could not find caller class: originating method call is obscured.");
                }
                switch ($matches[1]) {
                    case 'self':
                    case 'parent':
                        return get_called_class($bt,$l+1);
                    default:
                        return $matches[1];
                }
            case '->': switch ($bt[$l]['function']) {
                    case '__get':
                        if (!is_object($bt[$l]['object'])) throw new Exception ("Edge case fail. __get called on non object.");
                        return get_class($bt[$l]['object']);
                    default: return $bt[$l]['class'];
                }
            default: throw new Exception ("Unknown backtrace method type");
        }
    } 
}

function array_fillkeys($target, $value='') {
    //Fill an array with keys
    $filledArray = array();
    foreach($target as $key=>$val) {
        $filledArray[$val] = is_array($value) ? $value[$key] : $value;
    }
    return $filledArray;
}

function url_exists($url) {
    //Check if a URL exists
    return (!$fp = curl_init($url)) ? false : true;
}

function rrmdir($dir) {
    //Remove an entire directoy 
    foreach(glob($dir.'/*') as $file) { 
        if(is_dir($file)) {
            rrmdir($file);
        } else {
            @unlink($file);
        }
    }
    @rmdir($dir);
}

function __($code) {
    //Alias for the translations
    return LangTrans::translate($code);
}

function url($url='', $admin=false) {
    //Alias for getting a proper url
    if (!is_array($url)) {
        return Url::getUrl($url, $admin);
    } else {
        return Url::getUrl($url[Lang::active()], $admin);
    }
}
?>