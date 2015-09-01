<?php
class User_Form extends Form{

	public function loginAdmin() {
		$fields = $this->field('email').'
					'.$this->field('password');
		return '<div class="simpleForm">
					<p>'.__('loginMessage').'</p>
					'.Form::createForm($fields, array('action'=>url('User/login', true), 'class'=>'formAdmin', 'submit'=>__('send'))).'
					<p><a href="'.url('User/forgot', true).'">'.__('passwordForgot').'</a></p>
				</div>';
	}

	public function forgot() {
		$fields = $this->field('email');
		return '<div class="simpleForm">
					<p>'.__('passwordForgotMessage').'</p>
					'.Form::createForm($fields, array('action'=>url('User/forgot', true), 'class'=>'formAdmin', 'submit'=>__('send'))).'
					<p><a href="'.url('User/login', true).'">'.__('tryLoginAgain').'</a></p>
				</div>';
	}

	public function updatePassword() {
		$fields = $this->field('email').'
				'.$this->field('password');
		return '<div class="simpleForm">
					<p>'.__('passwordTempMessage').'</p>
					'.Form::createForm($fields, array('action'=>url('User/updatePassword', true), 'class'=>'formAdmin', 'submit'=>__('send'))).'
				</div>';
	}

	public function changePassword() {
		$this->errors['oldPassword'] = isset($this->errors['oldPassword']) ? $this->errors['oldPassword'] : '';
		$fields = FormFields_Password::create(array('label'=>__('oldPassword'), 'name'=>'oldPassword', 'error'=>$this->errors['oldPassword'])).'
				'.$this->field('password');
		return '<div class="simpleForm">
					<p>'.__('changePasswordMessage').'</p>
					'.Form::createForm($fields, array('action'=>url('User/changePassword', true), 'class'=>'formAdmin', 'submit'=>__('save'))).'
				</div>';
	}

	public function isValidChangePassword($login) {
		$errors = array();
		$user = User::read($login->id());
		if (md5($this->values['oldPassword']) != $user->get('password')) {
			$errors['oldPassword'] = __('oldPasswordError');
		}
		$error = $this->isValidField($this->object->attributeInfo('password'));
		if (count($error)>0) {
			$errors = array_merge($error, $errors);
		}
		return $errors;
	}

	public function myInformation() {
		$fields = $this->field('email').'
				'.$this->field('name');
		return '<div class="simpleForm">
					<p>'.__('myInformationMessage').'</p>
					'.Form::createForm($fields, array('action'=>url('User/myInformation', true), 'class'=>'formAdmin', 'submit'=>__('save'))).'
				</div>';
	}

	public function isValidMyInformation() {
		$errors = array();
		$items = array('email', 'name');
		foreach ($items as $item) {
			$error = $this->isValidField($this->object->attributeInfo($item));
			if (count($error)>0) {
				$errors = array_merge($error, $errors);
			}			
		}
		return $errors;
	}
	
}
?>