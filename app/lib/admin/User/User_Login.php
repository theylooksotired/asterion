<?php
class User_Login {
    
    protected static $login = null;
    protected $info;

    private function __construct() {
        $this->info = Session::get('infoUser');
        $this->info = ($this->info=='') ? array() : $this->info;
    }
    
    private function __clone() {}

    public static function getInstance() {
        //There's just one instance of this object
        if (null === self::$login) {
            self::$login = new self();
        }
        return self::$login;
    }
    
    public function id() {
        return $this->get('idUser');
    }

    public function get($value) {
        return (isset($this->info[$value])) ? $this->info[$value] : '';
    }
    
    private function sessionAdjust($info=array()) {
        //Update the session array
        Session::set('infoUser', $info);
    }

    public function isConnected() {
        //Check if the user is connected
        return (isset($this->info['idUser']) && $this->info['idUser']!='') ? true : false;
    }
    
    public function checklogin($options) {
        //Check the user login using it's email and password. If so, it saves the user values in the session
        $email = (isset($options['email'])) ? $options['email'] : '';
        $password = (isset($options['password'])) ? $options['password'] : '';
        $user = User::readFirst(array('where'=>'email="'.$email.'" AND password="'.md5($password).'" AND active="1"'));
        if ($user->id()!='') {
            $this->autoLogin($user);
            $this->sessionAdjust($this->info);
            return true;
        } else {
            return false;
        }
    }

    public function autoLogin($user) {
        //Automatically login a user
        $type = UserType::read($user->get('idUserType'));
        $this->info['idUser'] = $user->id();
        $this->info['email'] = $user->get('email');
        $this->info['label'] = $user->getBasicInfo();
        $this->info['code'] = $type->get('code');
        $this->info['idUserType'] = $type->id();
        $this->sessionAdjust($this->info);
    }

    public function logout() {
        //Eliminate session values and logout a user
        $this->info = array();
        $this->sessionAdjust();
    }
    
}
?>