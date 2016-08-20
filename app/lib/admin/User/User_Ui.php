<?php
/**
* @class UserUi
*
* This class manages the UI for the User objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/

class User_Ui extends Ui{

    static public function infoHtml() {
        $login = User_Login::getInstance();
        if ($login->isConnected()) {        
            return '<div class="infoUser">
                        <ul>
                            <li>
                                <a href="'.url('User/myInformation', true).'">'.__('myInformation').' ('.$login->get('label').')</a>
                            </li>
                            <li>
                                <a href="'.url('User/changePassword', true).'">'.__('changePassword').'</a>
                            </li>
                            <li>
                                <a href="'.url('User/logout', true).'">'.__('logout').'</a>
                            </li>
                        </ul>
                    </div>';
        }
    }
    
}

?>