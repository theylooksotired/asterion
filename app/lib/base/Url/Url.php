<?php
class Url {

  static public function format($url) {
    //Format a URL, adding the proper http, https or www if it's missing
    if (substr($url,0,8)=='https://' || substr($url,0,7)=='http://') {
      return $url;
    } else {
      if (substr($url,0,3)=='www') {
        return 'http://'.$url;
      } else {
        return 'http://www.'.$url;
      }
    }
  }
  
  static public function currentUrl() {
    //Return the current url
    $url = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$url .= "s";}
      $url .= "://";
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
      $url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
      $url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $url;
  }

  static public function initLang() {
    //Initialize the url when using multiple language
    $url = (isset($_GET['url'])) ? $_GET['url'] : '';
    $info = explode('/', $url);
    $pagerString = PAGER_URL_STRING;
    if (isset($info[0]) && $info[0]==ADMIN_URL_STRING) {
      //If the url points to the admin area
      $_GET['mode'] = 'admin';
      $_GET['lang'] = (isset($info[1])) ? $info[1] : '';
      $_GET['type'] = (isset($info[2]) && $info[2]!='') ? $info[2] : 'NavigationAdmin';
      if (isset($info[3]) && $info[3]==$pagerString) {
        $_GET['page'] = (isset($info[4])) ? $info[4] : '';
      } else {
        $_GET['action'] = (isset($info[3])) ? $info[3] : '';
        if (isset($info[4]) && $info[4]==$pagerString) {
          $_GET['page'] = (isset($info[5])) ? $info[5] : '';
        } else {
          $_GET['id'] = (isset($info[4])) ? $info[4] : '';
          if (isset($info[5]) && $info[5]==$pagerString) {
            $_GET['page'] = (isset($info[6])) ? $info[6] : '';
          } else {
            $_GET['extraId'] = (isset($info[5])) ? $info[5] : '';
            if (isset($info[6]) && $info[6]==$pagerString) {
              $_GET['page'] = (isset($info[7])) ? $info[7] : '';
            } else {
              $_GET['addId'] = (isset($info[6])) ? $info[6] : '';
            }
          }
        }
      }
    } else {
      //If the url points to the public area
      $_GET['lang'] = (isset($info[0])) ? $info[0] : '';
      $_GET['type'] = 'Navigation';
      $_GET['action'] = (isset($info[1])) ? $info[1] : '';
      if (isset($info[2]) && $info[2]==$pagerString) {
        $_GET['page'] = (isset($info[3])) ? $info[3] : '';
      } else {
        $_GET['id'] = (isset($info[2])) ? $info[2] : '';
        if (isset($info[3]) && $info[3]==$pagerString) {
          $_GET['page'] = (isset($info[4])) ? $info[4] : '';
        } else {
          $_GET['extraId'] = (isset($info[3])) ? $info[3] : '';
          if (isset($info[4]) && $info[4]==$pagerString) {
            $_GET['page'] = (isset($info[5])) ? $info[5] : '';
          } else {
            $_GET['addId'] = (isset($info[4])) ? $info[4] : '';
          }
        }
      }
    }
    $_GET['action'] = (isset($_GET['action']) && $_GET['action']!='') ? $_GET['action'] : 'intro';
  }

  static public function init() {
    if (count(Lang::langs())>1) {
      return Url::initLang();
    }
    //Initialize the url when using only one language
    $url = (isset($_GET['url'])) ? $_GET['url'] : '';
    $info = explode('/', $url);
    $pagerString = (Params::param('pagerString')!='') ? Params::param('pager-string') : PAGER_URL_STRING;
    if (isset($info[0]) && $info[0]==ADMIN_URL_STRING) {
      //If the url points to the admin area
      $_GET['mode'] = 'admin';
      $_GET['type'] = (isset($info[1]) && $info[1]!='') ? $info[1] : 'NavigationAdmin';
      if (isset($info[2]) && $info[2]==$pagerString) {
        $_GET['page'] = (isset($info[3])) ? $info[3] : '';
      } else {
        $_GET['action'] = (isset($info[2])) ? $info[2] : '';
        if (isset($info[3]) && $info[3]==$pagerString) {
          $_GET['page'] = (isset($info[4])) ? $info[4] : '';
        } else {
          $_GET['id'] = (isset($info[3])) ? $info[3] : '';
          if (isset($info[4]) && $info[4]==$pagerString) {
            $_GET['page'] = (isset($info[5])) ? $info[5] : '';
          } else {
            $_GET['extraId'] = (isset($info[4])) ? $info[4] : '';
            if (isset($info[5]) && $info[5]==$pagerString) {
              $_GET['page'] = (isset($info[6])) ? $info[6] : '';
            } else {
              $_GET['addId'] = (isset($info[5])) ? $info[5] : '';
            }
          }
        }
      }
    } else {
      //If the url points to the public area
      $_GET['type'] = 'Navigation';
      $_GET['action'] = (isset($info[0])) ? $info[0] : '';
      if (isset($info[1]) && $info[1]==$pagerString) {
        $_GET['page'] = (isset($info[2])) ? $info[2] : '';
      } else {
        $_GET['id'] = (isset($info[1])) ? $info[1] : '';
        if (isset($info[2]) && $info[2]==$pagerString) {
          $_GET[$pagerString] = (isset($info[3])) ? $info[3] : '';
        } else {
          $_GET['extraId'] = (isset($info[2])) ? $info[2] : '';
          if (isset($info[3]) && $info[3]==$pagerString) {
            $_GET['page'] = (isset($info[4])) ? $info[4] : '';
          } else {
            $_GET['addId'] = (isset($info[3])) ? $info[3] : '';
          }
        }
      }
    }
    $_GET['lang'] = LANGS;
    $_GET['action'] = (isset($_GET['action']) && $_GET['action']!='') ? $_GET['action'] : 'intro';
  }

  static public function urlLang($newLang) {
    //Create an URL using the language code
    $url = (isset($_GET['url'])) ? $_GET['url'] : '';
    $info = explode('/', $url);
    if (isset($info[0]) && $info[0]==ADMIN_URL_STRING) {
      $info[1] = $newLang;
    } else {
      $info[0] = $newLang;
    }
    return LOCAL_URL.implode('/', $info);
  }

  static public function urlPage($page) {
    //Create an URL
    $url = (isset($_GET['url'])) ? $_GET['url'] : '';
    $infoInfo = explode('/', $url);
    $info = array();
    foreach ($infoInfo as $infoEle) {
      if ($infoEle!='') {
        $info[] = $infoEle;
      }
    }
    $key = array_search(PAGER_URL_STRING, $info);
    if ($key!==false) {
      if (isset($info[$key+1])) {
        $info[$key+1] = $page;
      } else {
        array_push($info, $page);
      }
    } else {
      array_push($info, PAGER_URL_STRING, $page);
    }
    return LOCAL_URL.implode('/', $info);
  }

  static public function getUrlLang($url='', $admin=false) {
    //Format an URL using the language code
    if ($admin) {
      return LOCAL_URL.ADMIN_URL_STRING.'/'.Lang::active().'/'.$url;
    } else {
      return LOCAL_URL.Lang::active().'/'.$url;
    }
  }

  static public function getUrl($url='', $admin=false) {
    //Format an URL
    if (count(Lang::langs())>1) {
      return Url::getUrlLang($url, $admin);
    }
    if ($admin) {
      return LOCAL_URL.ADMIN_URL_STRING.'/'.$url;
    } else {
      return LOCAL_URL.$url;
    }
  }

}
?>