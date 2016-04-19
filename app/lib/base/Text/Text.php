<?php
class Text {

  static public function strip($text) {
    //Strip a text string
    return strip_tags(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
  }

  static public function cutWords($text, $numWords) {
    //Cut and decode a string by the number of words
    $html = '';
    $textOriginal = $text;
    $text = strip_tags($text);
    $text = htmlspecialchars_decode($text);
    $textArray = explode(' ',$text);
    $textArray = array_slice($textArray, 0, $numWords);
    foreach ($textArray as $word) {
      $html .= $word.' ';
    }
    return $html;
  }
  
  static public function cutWordsSimple($text, $numWords) {
    //Cut a string by the number of words
    $html = '';
    foreach ($textArray as $word) {
      $word = (strlen($word)>25) ? substr($word, 0, 25).'...' : $word;
      $html .= $word.' ';
    }
    return $html;
  }

    static public function simple($text, $space='-') {
      //Convert a text string into a friendly one
    return str_replace('.','',Text::simpleUrl($text, $space));
    }

  static public function simpleUrlFileBase($text, $space='-') {
    //Convert a basename into a friendly one
        $info = pathinfo($text);
        return str_replace('.', '', Text::simpleUrl($info['filename'], $space));
    }

  static public function simpleUrlFile($text, $space='-') {
    //Convert a filename into a friendly one
        $info = pathinfo($text);
        return str_replace('.', '', Text::simpleUrl($info['filename'], $space)).'.'.$info['extension'];
    }

    static public function simpleUrl($text, $space='-') {
      //Convert a text string into a friendly url
        $search  = array('@','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ','ñ','Ñ');
        $replace = array('','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','u','u','u','u','y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y','n','N');
        $text = str_replace($search, $replace, trim($text));
        $text = preg_replace('/([^a-z0-9.]+)/i', $space, $text);
        $text = str_replace('.', '', $text);
        $text = strtolower($text);
        $text = trim($text);
        $text = trim($text, '-');
        return $text;
    }
    
  static public function booleanText($text) {
    //Check if the text string is boolean
    return ($text==1 || $text==true) ? __('yes') : __('no');
  }
  
  static public function dateNumber($number) {
    //Format a date number
    return str_pad($number, 2, "0", STR_PAD_LEFT);
  }
  
  static public function money($number) {
    //Format a value into money
    return number_format(floatval($number), 2, ',', '');
  }

  static public function moneyDollar($number) {
    //Format a value into money
    return Text::money($number).' <span>$USD</span>';
  }

  static public function moneyEuros($number) {
    //Format a value into money
    return Text::money($number).' <span>&euro;</span>';
  }
  
  static public function csvArray($text) {
    //Convert a CSV into an array
    $list = explode(',',$text);
    $result = array();
    foreach($list as $item) {
      if (trim($item)!='') {
        array_push($result,trim($item));
      }
    }
    return $result;
  }
  
  static public function normal($text) {
    //Normalize a text string
    return utf8_encode(html_entity_decode($text));
  }
  
  static public function minimize($text) {
    //Compress a text string
    return preg_replace(array('/ {2,}/', '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'), array(' ',''), $text);
  }

  static public function escape($text) {
    //Escape a text string
    return str_replace('"', '\"', $text);
  }

  static public function escapeTab(& $tab) {
    //Escape an entire array
    while (list($k, $v) = each($tab)) {
      if (!is_array($tab[$k])) {
        $tab[$k] = Text::escape($tab[$k]);
      } else {
        Text::escape($tab[$k]);
      }
    }
  }

  static public function recodeText($text, $quotes = ENT_QUOTES, $charset = "utf-8") {
    //Recode a text string
    $text = strtr($text,chr(146),"'");
    return trim(htmlentities(stripslashes($text), $quotes, $charset));
  }

  static public function recodeTextSQ($text) {
    //Recode a text string with some special characters
    $text = Text::recodeText($text, ENT_NOQUOTES);
    $text = str_replace("'", "&#039;", $text);
    $text = str_replace("&lt;", "<", $text);
    $text = str_replace("&gt;", ">", $text);
    return $text;
  }
 
  static public function recodeTab(& $tab, $sqOnly = array(), $mce = array()) {
    //Recode an entire array
    while (list($k, $v) = each($tab)) {
      if (!is_array($tab[$k])) {
        if (in_array($k, $sqOnly)) {
          $tab[$k] = Text::recodeTextSQ($tab[$k]);
        } elseif (in_array($k, $mce)) {
        } else {
          $tab[$k] = Text::recodeText($tab[$k]);
        }  
      } else {
        if (in_array($k, $sqOnly)) {
          $exc = array_merge($sqOnly, array_keys($tab[$k])); 
          Text::recodeTab($tab[$k], $exc, $mce);
        } elseif (in_array($k, $mce)) {
          $exc = array_merge($mce, array_keys($tab[$k])); 
          Text::recodeTab($tab[$k], $sqOnly, $exc);
        } else {
          Text::recodeTab($tab[$k], $sqOnly);
        }
      }
    }
  }

  static public function escQuotes($text) {
    //Recode the escape quotes
    return str_replace('\"', "&quot;", $text);
  }

  static public function decodeText($text, $quotes = ENT_QUOTES, $charset = "utf-8") {
    //Decode a text string
    return html_entity_decode($text, $quotes, $charset);
  }
  
}
?>