<?php
/**
* @class UserController
*
* This class is the controller for the User objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class User_Controller extends Controller {

    public function controlActions(){
        $ui = new NavigationAdmin_Ui($this);
        switch ($this->action) {
            case 'login':
                $this->mode = 'admin';
                $this->layoutPage = 'simple';
                $this->titlePage = __('login');
                if (count($this->values)>0) {
                    $login = User_Login::getInstance();
                    $login->checklogin($this->values);
                    if ($login->isConnected()) {
                        header('Location: '.url('NavigationAdmin/intro', true));
                    } else {
                        $form = new User_Form();
                        $this->messageError = __('errorConnection');
                        $this->content = $form->loginAdmin();
                    }
                } else {                
                    $form = new User_Form();
                    $this->content = $form->loginAdmin();
                }
                return $ui->render();
            break;
            case 'logout':
                $login = User_Login::getInstance();
                $login->logout();
                header('Location: '.url('', true));
            break;
            case 'forgot':
                $this->mode = 'admin';
                $this->layoutPage = 'simple';
                $this->titlePage = __('passwordForgot');
                if (isset($this->values['email'])) {
                    $user = User::readFirst(array('where'=>'email="'.$this->values['email'].'" AND active="1"'));
                    if ($user->id()!='') {
                        $tempPassword = substr(md5(rand()*rand()), 0, 10);
                        $user->modify(array('passwordTemp'=>$tempPassword));
                        $updatePasswordLink = url('User/updatePassword', true);
                        HtmlMail::send($user->get('email'), 'passwordForgot', array('TEMP_PASSWORD'=>$tempPassword, 'UPDATE_PASSWORD_LINK'=>$updatePasswordLink));
                        $this->message = __('passwordSentMail');
                    } else {
                        $this->messageError = __('mailDoesntExist');
                        $form = new User_Form();
                        $this->content = $form->forgot();
                    }
                } else {
                    $form = new User_Form();
                    $this->content = $form->forgot();
                }
                return $ui->render();
            break;
            case 'updatePassword':
                $this->mode = 'admin';
                $this->titlePage = __('updatePassword');
                $this->layoutPage = 'simple';
                if (isset($this->values['email'])) {
                    $passwordTemp = (isset($this->values['password'])) ? $this->values['password'] : '';
                    $user = User::readFirst(array('where'=>'email="'.$this->values['email'].'" AND passwordTemp="'.$passwordTemp.'" AND passwordTemp IS NOT NULL AND passwordTemp!="" AND active="1"'));
                    if ($user->id()!='') {
                        $user->modify(array('password'=>$user->get('passwordTemp'), 'passwordTemp'=>''));
                        $login = User_Login::getInstance();
                        $login->autoLogin($user);
                        header('Location: '.url('', true));
                    } else {
                        $this->messageError = __('updatePasswordError');
                        $form = new User_Form();
                        $this->content = $form->updatePassword();
                    }
                } else {
                    $form = new User_Form();
                    $this->content = $form->updatePassword();
                }
                return $ui->render();
            break;
            case 'changePassword':
                $this->mode = 'admin';
                $this->titlePage = __('changePassword');
                $login = User_Login::getInstance();
                if ($login->isConnected()) {
                    if (count($this->values) > 0) {
                        $form = new User_Form($this->values);
                        $errors = $form->isValidChangePassword($login);
                        if (count($errors) > 0) {
                            $form = new User_Form(array(), $errors);
                            $this->messageError = __('changePasswordError');
                            $this->content = $form->changePassword();
                        } else {
                            $user = User::read($login->id());
                            $user->modify($this->values, array('complete'=>false));
                            $this->message = __('changePasswordSuccess');
                        }
                    } else {
                        $form = new User_Form();
                        $this->content = $form->changePassword();
                    }
                    return $ui->render();
                } else {
                    header('Location: '.ADMIN_URL);
                }
            break;
            case 'myInformation':
                $this->mode = 'admin';
                $this->titlePage = __('myInformation');
                $login = User_Login::getInstance();
                if ($login->isConnected()) {
                    $user = User::read($login->id());
                    if (count($this->values) > 0) {
                        $form = new User_Form($this->values);
                        $errors = $form->isValidMyInformation($this->values);
                        if (count($errors) > 0) {
                            $form = new User_Form($this->values, $errors);
                            $this->messageError = __('errorsForm');
                            $this->content = $form->myInformation();
                        } else {
                            $user->modify($this->values, array('complete'=>false));
                            $form = User_Form::newObject($user);
                            $this->message = __('savedForm');
                            $this->content = $form->myInformation();
                        }
                    } else {
                        $form = User_Form::newObject($user);
                        $this->content = $form->myInformation();                        
                    }
                    return $ui->render();
                } else {
                    header('Location: '.ADMIN_URL);
                }
            break;
        }
        return parent::controlActions();
    }    
}
?>