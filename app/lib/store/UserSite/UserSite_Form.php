<?php
class UserSite_Form extends Form{

	public function create() {
		$fields = '<div class="formInsFields">
						'.$this->field('name').'
						'.$this->field('telephone').'
						'.$this->field('email').'
						'.$this->field('password').'
						'.FormFields_Hidden::create(array('name'=>'form', 'value'=>'create')).'
					</div>';
		return '<div class="formSiteWrapper formSiteCreate">
					'.Form::createForm($fields, array('action'=>url('login'), 'submit'=>__('send'), 'class'=>'formSite formLogin')).'
				</div>';
	}

	public function updatePassword() {
		$fields = '<h2>'.__('passwordTempMessage').'</h2>
					'.$this->field('email').'
					'.$this->field('password');
		return '<div class="simpleForm">
					'.Form::createForm($fields, array('action'=>url('update-password'), 'class'=>'formSite formLogin', 'submit'=>__('send'))).'
				</div>';
	}

	public function isValidCreate($values) {
		$errors = array();
		if (!isset($values['name']) || strlen(trim($values['name'])) == 0) { 
			$errors['name'] = __('notEmpty');
		}
		if (!isset($values['email']) || strlen(trim($values['email'])) == 0) { 
			$errors['email'] = __('notEmpty');
		}
		if (!isset($values['password']) || strlen(trim($values['password'])) == 0) { 
			$errors['password'] = __('notEmpty');
		} else {
			if (strlen($values['password']) < 6) { 
				$errors['password'] = __('errorPasswordSize');
			}
			if (preg_match('/^[a-z0-9]+$/i', $values['password'])==false) {
				$errors['password'] = __('errorPasswordAlpha');
			}
		}
		$userExists = UserSite::readFirst(array('where'=>'email="'.$values['email'].'" AND active="1"'));
		if ($userExists->id()!='') {
			$errors['email'] = __('userExists');
		}
		return $errors;
	}

	public function login($error = false) {
		$errorHtml = ($error) ? '<p class="error errorHtml">'.__('errorConnection').'</p>' : '';
		$fields = '<div class="formInsFields">
						<div class="formInsFieldsIns">
							'.$errorHtml.'
							'.FormFields_Text::create(array('name'=>'email', 'label'=>__('email'), 'value'=>'')).'
							'.FormFields_Password::create(array('name'=>'password', 'label'=>__('password'), 'value'=>'')).'
							'.FormFields_Hidden::create(array('name'=>'form', 'value'=>'login')).'
						</div>
					</div>';
		return '<div class="formSiteWrapper formSiteLogin">
					'.Form::createForm($fields, array('action'=>url('login'), 'submit'=>__('login'), 'class'=>'formSite formLogin')).'
					<div class="formSiteOptions">
						<p><a href="'.url('login/create').'" class="ajaxLink">'.__('createAccount').'</a></p>
						<p><a href="'.url('login/forgot').'" class="ajaxLink">'.__('passwordForgot').'</a></p>
					</div>
					<div class="loginSocialWrapper">
						<div class="loginSocial loginSocialFacebook">
							<div class="loginSocialIns">S\'identifier avec Facebook</div>
						</div>
						<div class="loginSocial loginSocialTwitter">
							<div class="loginSocialIns">S\'identifier avec Twitter</div>
						</div>
						<div class="clearer"></div>
					</div>
				</div>';
	}

	static public function forgot() {
		$fields = '<div class="formInsFields">
						<div class="formInsFieldsIns">
							'.FormFields_Text::create(array('name'=>'email', 'label'=>__('email'))).'
							'.FormFields_Hidden::create(array('name'=>'form', 'value'=>'forgot')).'
						</div>
					</div>';
		return '<div class="formSiteWrapper formSiteLogin">
					<p>'.__('passwordForgotMessage').'</p>
					'.Form::createForm($fields, array('action'=>url('login'), 'submit'=>__('send'), 'class'=>'formSite formLogin')).'
					<div class="formSiteOptions">
						<p><a href="'.url('login').'" class="ajaxLink">'.__('tryLoginAgain').'</a></p>
					</div>
				</div>';
	}

	static public function createThanks() {
		return '<div class="formSiteWrapper">
					<div class="message">
						<p>'.__('createThanks').'</p>
					</div>
				</div>';
	}

	static public function forgotThanks() {
		return '<div class="formSiteWrapper">
					<div class="message">
						<p>'.__('forgotThanks').'</p>
						<p><a href="'.url('login').'" class="ajaxLink">'.__('loginAgain').'</a></p>
					</div>
				</div>';
	}

}
?>