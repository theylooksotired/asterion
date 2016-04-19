<?php
class XML {
  
  static public function writeXML($fileName, $content, $headers='') {
    //Write an XML file
    switch($headers) {
      default:
      case 'rss':
        $contentXML = XML::formatRss($content);
      break;
      case 'sitemap':
        $contentXML = XML::formatSitemap($content);
      break;
    }
    if (!file_exists($fileName)) {
      touch($fileName);
    }
    $handle = fopen($fileName, "wb");
    $numbytes = fwrite($handle, $contentXML);
    fclose($handle);
  }

  static public function toArray($xmlObject, &$array) {
    //Convert a XML file into an array
    $children = $xmlObject->children();
    foreach ($children as $elementName => $node) {
      $nextIdx = count($array);
      $array[$nextIdx] = array();
      $array[$nextIdx]['@name'] = strtolower((string)$elementName);
      $array[$nextIdx]['@attributes'] = array();
      $attributes = $node->attributes();
      foreach ($attributes as $attributeName => $attributeValue) {
        $attribName = strtolower(trim((string)$attributeName));
        $attribVal = trim((string)$attributeValue);
        $array[$nextIdx]['@attributes'][$attribName] = $attribVal;
      }
      $text = (string)$node;
      $text = trim($text);
      if (strlen($text) > 0) {
        $array[$nextIdx]['@text'] = $text;
      }
      $array[$nextIdx]['@children'] = array();
      XML::toArray($node, $array[$nextIdx]['@children']);
    }
    return;
  }

  static public function readClass($class) {
    //Read the XML file containing the class
    $fileXML = '';
    $addLocation = $class.'/'.$class.'.xml';
    foreach ($_ENV['locations'] as $location) {
      $fileXML = (is_file($location.$addLocation)) ? $location.$addLocation : $fileXML;
    }
    return simplexml_load_file($fileXML);
  }

  static public function formatRss($content, $options=array()) {
    //Format a XML RSS file
    $title = (isset($options['title'])) ? $options['title'] : Params::param('titlePage');
    $link = (isset($options['link'])) ? $options['link'] : LOCAL_URL;
    $description = (isset($options['description'])) ? $options['description'] : Params::param('metaDescription');
    return '<?xml version="1.0" encoding="ISO-8859-1"?>
          <rss version="2.0">
          <channel>
            <title>'.$title.'</title>
            <link>'.$link.'</link>
            <description>'.$description.'</description>
            <language>'.Lang::active().'</language> 
            <lastBuildDate>'.date('l jS \of F Y h:i:s A').'</lastBuildDate> 
            <administrator>'.Params::param('titlePage').'</administrator>
            <image>
              <title>'.Params::param('titlePage').'</title>
              <url>'.LOGO.'</url>
              <link>'.LOCAL_URL.'</link>
              <description>'.Params::param('metaDescription').'</description>
            </image>
            '.$content.'
          </channel>
          </rss>';
  }

  static public function formatSitemap($content) {
    //Format a XML sitemap file
    return '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
          '.$content.'
        </urlset>';
  }
  
}
?>