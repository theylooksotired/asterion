<?php
class UserSite_Login {
	
	protected static $login = null;
	protected $info;

	private function __construct() {
		$this->info = Session::get('infoUserSite');
		$this->info = ($this->info=='') ? array() : $this->info;
	}
	
	private function __clone() {}

	public static function getInstance() {
		if (null === self::$login) {
			self::$login = new self();
		}
		return self::$login;
	}
	
	public function id() {
		return (isset($this->info['idUserSite'])) ? $this->info['idUserSite'] : '';
	}

	public function get($value) {
		return (isset($this->info[$value])) ? $this->info[$value] : '';
	}
	
	private function sessionAdjust($info=array()) {
		Session::set('infoUserSite', $info);
	}

	public function isConnected() {
		return (isset($this->info['idUserSite']) && $this->info['idUserSite']!='') ? true : false;
	}
	
	public function checklogin($options) {
		$email = (isset($options['email'])) ? $options['email'] : '';
		$password = (isset($options['password'])) ? $options['password'] : '';
		$user = UserSite::readFirst(array('where'=>'email="'.$email.'"AND password="'.md5($password).'" AND active="1"'));
		if ($user->id()!='') {
			$this->info['idUserSite'] = $user->id();
			$this->info['email'] = $user->get('email');
			$this->info['label'] = $user->getBasicInfo();
			$this->sessionAdjust($this->info);
			return true;
		} else {
			return false;
		}
	}

	public function autoLogin($user) {
		$this->info['idUserSite'] = $user->id();
		$this->info['email'] = $user->get('email');
		$this->info['label'] = $user->getBasicInfo();
		$this->sessionAdjust($this->info);
	}

	public function logout() {
		$this->info = array();
		$this->sessionAdjust();
	}
	
}
?>