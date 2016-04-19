<?php
class Session {
  
  static public function get($name) {
    //Get a session element
    return (isset($_SESSION[SESSION_NAME][$name])) ? $_SESSION[SESSION_NAME][$name] : '';
  }

  static public function getLogin($name) {
    //Get the session login information
    return (isset($_SESSION[SESSION_NAME]['info'][$name])) ? $_SESSION[SESSION_NAME]['info'][$name] : '';
  }

  static public function set($name, $value) {
    //Set a session element
    $_SESSION[SESSION_NAME][$name] = $value;
  }
  
  static public function delete($name) {
    //Delete a session element
    if (isset($_SESSION[SESSION_NAME][$name])) {
      $_SESSION[SESSION_NAME][$name] = '';
      unset($_SESSION[SESSION_NAME][$name]);
    }
  }
  
}
?>