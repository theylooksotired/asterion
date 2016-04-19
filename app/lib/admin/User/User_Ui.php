<?php

class User_Ui extends Ui{

  protected $object;

  public function __construct (User & $object) {
    $this->object = $object;
  }

  static public function infoHtml() {
    $login = User_Login::getInstance();
    if ($login->isConnected()) {    
      return '<div class="infoUser">
            <p>
              <a href="'.url('User/myInformation', true).'">'.__('myInformation').' ('.$login->get('label').')</a> | 
              <a href="'.url('User/changePassword', true).'">'.__('changePassword').'</a> | 
              <a href="'.url('User/logout', true).'">'.__('logout').'</a>
            </p>
          </div>';
    }
  }
  
}

?>