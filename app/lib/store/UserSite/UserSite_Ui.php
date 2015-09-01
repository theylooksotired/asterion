<?php

class UserSite_Ui extends Ui {

	protected $object;

	public function __construct (UserSite & $object) {
		$this->object = $object;
	}

	static public function infoHtml() {
		$login = UserSite_Login::getInstance();
		if ($login->isConnected()) {
			$user = UserSite::read($login->id());
			$html = '<div class="loginSmall"><span>'.$login->get('label').'</span> | <a href="'.url('logout').'">Salir</a></div>';
		} else {
			$html = '<div class="loginSmall loginSmallUser"><a href="'.url('conectarse').'">Acceso a usuarios</a></div>';
		}
		return '<div class="infoUser">'.$html.'</div>';
	}

	static public function linkLogin() {
		$login = UserSite_Login::getInstance();
		if ($login->isConnected()) {
			return '<a href="'.url(array('en'=>'my-page', 'fr'=>'ma-page')).'">'.$login->get('email').'</a>';
		} else {
			return '<a href="'.url(array('en'=>'login', 'fr'=>'identification')).'">'.__('login').'</a>';
		}
	}

	public function renderSimple() {
		return '<div class="userSimple">
					<div class="userSimpleLeft">
						<div class="userSimpleImage" style="background-image:url('.$this->object->getImageUrl('image', 'small', BASE_URL.'visual/img/icoPerson.png').');"></div>
					</div>
					<div class="userSimpleRight">
						<p>'.$this->object->get('name').'</p>
					</div>
					<div class="clearer"></div>
				</div>';
	}

	public function renderBoatSimple() {
		return '<div class="userBoatSimple">
					'.$this->renderSimple().'
					<div class="clearer"></div>
					'.$this->badges().'
				</div>';
	}
	
	public function renderMyPageIntro($options=array()) {
		$boat = (isset($options['boat'])) ? $options['boat'] : '';
		if ($this->object->isSailor()) {
			$bottomHtml = '<div class="myPageIntroDown">
								<div class="myPageDownSingle">
									<h2 class="titlePageDown">'.__('site_lastPosts').'</h2>
									<div class="myPageIntroDownIns">
										'.Post_Ui_Html::blockMyPage().'
									</div>
								</div>
							</div>';
		} else {
			$bottomHtml = '<div class="myPageIntroDown">
								<div class="myPageDownLeft">
									<h2 class="titlePageDown">'.__('site_myBoatLog').'</h2>
									<div class="myPageIntroDownIns">
										'.BoatLog_Ui_Html::blockMyPage($boat).'
									</div>
								</div>
								<div class="myPageDownRight">
									<h2 class="titlePageDown">'.__('site_lastPosts').'</h2>
									<div class="myPageIntroDownIns">
										'.Post_Ui_Html::blockMyPage().'
									</div>
								</div>
								<div class="clearer"></div>
							</div>';
		}
		return '<div class="myPageIntro">
					<div class="myPageIntroTop">
						<div class="myPageIntroTopIns">
							'.$this->object->showUi('MyPage', array('boat'=>$boat)).'
						</div>
					</div>
					<div class="myPagePlanning">
						'.$boat->showUi('Planning').'
					</div>
					'.$bottomHtml.'
				</div>';
	}

	public function renderMyPage($options=array()) {
		$boat = (isset($options['boat'])) ? $options['boat'] : '';
		$login = UserSite_Login::getInstance();
		$user = UserSite::read($login->id());
		if (!$this->object->isCaptain()) {
			$boats = new ListObjects('Boat', array('where'=>'idUserSite="'.$this->object->id().'"', 'order'=>'ord'));
		} else {
			$boats = new ListObjects('Boat', array('where'=>'idBoatCaptain="'.$this->object->id().'"', 'order'=>'ord'));
		}
		return '<div class="userMyPage">
					<div class="sectionFieldUser">
						<div class="sectionFieldUserLeft">
							'.$this->object->getImage('image', 'small', '<div class="imageEmptyPerson"></div>').'
						</div>
						<div class="sectionFieldUserRight">
							<div class="sectionFieldUserRightLeft">
								<h2>'.$this->object->getBasicInfo().'</h2>
								<p>'.$this->object->label('type').' <strong>'.$this->object->getBasicInfo().'</strong></p>
								<p>'.__('site_subscribedFrom').' <strong>'.Date::sqlText($this->object->get('created')).'</strong></p>
							</div>
							<div class="sectionFieldUserRightRight">
								'.Notification_Ui_Html::showAll($this->object->id()).'
							</div>
							<div class="clearer"></div>
						</div>
						<div class="clearer"></div>
						<div class="listBoatsMyPageIntro">
							'.$boats->showList(array('function'=>'MyPageIntro'), array('idBoatSelected'=>$boat->id())).'
						</div>
					</div>
				</div>';
	}

	public function renderBoats($options=array()) {
		if (!isset($options['boat'])) {
			return '';
		}
		$boat = $options['boat'];
		$boatForm = Boat_Form::newObject($boat);
		$boatForm->loadServices();
		$addBoat = '';
		$fieldsFees = '';
		if (!$this->object->isCaptain()) {
			$boats = new ListObjects('Boat', array('where'=>'idUserSite="'.$this->object->id().'"', 'order'=>'ord'));
			$addBoat = '<p class="btnGreen btnGreenCenter">
							<a href="'.url(array('en'=>'boats/create', 'fr'=>'bateaux/creer')).'">'.__('site_addBoat').'</a>
						</p>';
			$fieldsFees = '<div class="sectionItem">
								<div class="sectionItemIns">
									<h3 class="titleSection">'.__('site_fees').'</h3>
									'.$boatForm->feesFields().'
									'.FormFields::show('submit', array('name'=>'submit3', 'value'=>__('save'), 'class'=>'formSubmit')).'
									<div class="clearer"></div>
								</div>
							</div>';
		} else {
			$boats = new ListObjects('Boat', array('where'=>'idBoatCaptain="'.$this->object->id().'"', 'order'=>'ord'));
		}
		$fields = '<div class="listBoatsWrapper">
						<div class="tableSite tableAll boatsTable">
							'.Boat_Ui_Html::renderTableHeader().'
							'.$boats->showList(array('function'=>'Table'), array('idBoatSelected'=>$boat->id())).'
						</div>
						'.$addBoat.'
					</div>
					<div class="sectionFieldsWrapper">
						<h2 class="titleSection">'.$boat->getBasicInfo().'</h2>
						<div class="sectionItem">
							<div class="sectionItemIns">
								<h3 class="titleSection">'.__('site_generalInformations').'</h3>
								'.$boatForm->createFields().'
								'.FormFields::show('submit', array('name'=>'submit1', 'value'=>__('save'), 'class'=>'formSubmit')).'
								<div class="clearer"></div>
							</div>
						</div>
						<div class="sectionItem">
							<div class="sectionItemIns">
								<h3 class="titleSection">'.__('site_informations').'</h3>
								'.$boatForm->informationFields().'
								'.FormFields::show('submit', array('name'=>'submit2', 'value'=>__('save'), 'class'=>'formSubmit')).'
								<div class="clearer"></div>
							</div>
						</div>
						'.$fieldsFees.'
						<div class="sectionItem">
							<div class="sectionItemIns">
								<h3 class="titleSection">'.__('site_visuals').'</h3>
								'.$boatForm->imageFields().'
								<div class="clearer"></div>
							</div>
						</div>
						'.FormFields::show('hidden', array('name'=>'idBoat', 'value'=>$boat->id())).'
					</div>';
		return Form::createForm($fields, array('action'=>url(array('en'=>'boats/view/'.$boat->id(), 'fr'=>'bateaux/voir/'.$boat->id())), 'submit'=>'ajax', 'class'=>'formSite formSiteComplete'));
	}

	public function renderProfile($options=array()) {
		$values = (isset($options['values'])) ? $options['values'] : array();
		$errors = (isset($options['errors'])) ? $options['errors'] : array();
		$login = UserSite_Login::getInstance();
		$user = UserSite::read($login->id());
		$address = UserSiteAddress::readFirst(array('where'=>'idUserSite="'.$user->id().'"'));
		$rib = UserSiteRib::readFirst(array('where'=>'idUserSite="'.$user->id().'"'));
		$userForm = UserSite_Form::newObject($user);
		$addressForm = UserSite_Form::newObject($address);
		$ribForm = UserSiteRib_Form::newObject($rib);
		if (count($errors)>0) {
			$userForm->addValues($values, $errors);
			$addressForm->addValues($values, $errors);
			$ribForm->addValues($values, $errors);
		}
		$completeForm = '';
		if ($this->object->isOwner()) {
			$completeForm = '<div class="sectionItem">
								<div class="sectionItemIns">
									<h3 class="titleSection">'.__('site_experience').'</h3>
									'.$userForm->experienceFields().'
									'.FormFields::show('submit', array('name'=>'submit4', 'value'=>__('save'), 'class'=>'formSubmit')).'
									<div class="clearer"></div>
								</div>
							</div>
							<div class="sectionItem">
								<div class="sectionItemIns">
									<h3 class="titleSection">'.__('site_rib').'</h3>
									'.$ribForm->ribFields().'
									'.FormFields::show('submit', array('name'=>'submit6', 'value'=>__('save'), 'class'=>'formSubmit')).'
									<div class="clearer"></div>
								</div>
							</div>';
		}
		$fields = '<div class="sectionFieldsWrapper sectionFieldsWrapperSimple">
						<div class="sectionItem">
							<div class="sectionItemIns">
								<h3 class="titleSection">'.$this->object->getBasicInfo().'</h3>
								<div class="sectionFieldUser">
									<div class="sectionFieldUserLeft">
										<div class="sectionFieldUserImage">
											'.$this->object->getImage('image', 'small', '<div class="imageEmptyPerson"></div>').'
										</div>
									</div>
									<div class="sectionFieldUserRight">
										'.$userForm->profileFieldsSimple().'
									</div>
									<div class="clearer"></div>
								</div>
								'.FormFields::show('submit', array('name'=>'submit1', 'value'=>__('save'), 'class'=>'formSubmit')).'
								<div class="clearer"></div>
							</div>
						</div>
						<div class="sectionItem">
							<div class="sectionItemIns">
								<h3 class="titleSection">'.__('password').'</h3>
								'.$userForm->changePassword().'
								'.FormFields::show('submit', array('name'=>'submit2', 'value'=>__('save'), 'class'=>'formSubmit')).'
								<div class="clearer"></div>
							</div>
						</div>
						<div class="sectionItem">
							<div class="sectionItemIns">
								<h3 class="titleSection">'.__('site_address').'</h3>
								'.$addressForm->addressFields().'
								'.FormFields::show('submit', array('name'=>'submit3', 'value'=>__('save'), 'class'=>'formSubmit')).'
								<div class="clearer"></div>
							</div>
						</div>
						'.$completeForm.'
						'.FormFields::show('hidden', array('name'=>'idUserSite', 'value'=>$this->object->id())).'
					</div>';
		return Form::createForm($fields, array('action'=>url(array('en'=>'profile', 'fr'=>'profil')), 'submit'=>'ajax', 'class'=>'formSite formSiteComplete'));
	}

	public function renderCvMarin($options=array()) {
		$values = (isset($options['values'])) ? $options['values'] : array();
		$errors = (isset($options['errors'])) ? $options['errors'] : array();
		$login = UserSite_Login::getInstance();
		$user = UserSite::read($login->id());
		$cvmarin = UserSiteCv::readFirst(array('where'=>'idUserSite="'.$user->id().'"'));
		$cvmarinForm = UserSiteCv_Form::newObject($cvmarin);
		if (count($errors)>0) {
			$cvmarinForm->addValues($values, $errors);
		}
		$fields = '<div class="sectionFieldsWrapper sectionFieldsWrapperSimple">
						<div class="sectionItem sectionItemSimple">
							<div class="sectionItemIns">
								'.$cvmarinForm->cvFields().'
								'.FormFields::show('submit', array('name'=>'submit1', 'value'=>__('save'), 'class'=>'formSubmit')).'
								<div class="clearer"></div>
							</div>
						</div>
						'.FormFields::show('hidden', array('name'=>'idUserSite', 'value'=>$this->object->id())).'
					</div>';
		return Form::createForm($fields, array('action'=>url(array('en'=>'cvmarin', 'fr'=>'cvmarin')), 'submit'=>'ajax', 'class'=>'formSite formSiteComplete formSiteCv'));
	}

	public function renderCertification($options=array()) {
		$login = UserSite_Login::getInstance();
		$user = UserSite::read($login->id());
		$boats = new ListObjects('Boat', array('where'=>'idUserSite="'.$this->object->id().'"', 'order'=>'ord'));
		$boatsCertification = '';
		if (!$boats->isEmpty()) {
			$boatsCertification = '<div class="sectionItem sectionItemSimple">
										<div class="sectionItemIns">
											<h3 class="titleSection">'.__('site_boatsCertification').'</h3>
											<div class="sectionPage">
												'.HtmlSection::show('certification-boats').'
											</div>
											<div class="listBoatsWrapper">
												<div class="tableSite tableAll boatsTable">
													'.Boat_Ui_Html::renderTableCertificationHeader().'
													'.$boats->showList(array('function'=>'TableCertification')).'
												</div>
											</div>
											<div class="clearer"></div>
										</div>
									</div>';
		}
		if ($this->object->get('certification')=='1') {
			$userCertification =  HtmlSection::show('certificated-user').'
									<div class="certificationDate">
										<p><strong>'.__('label_dateCertification').':</strong> '.Date::sqlText($this->object->get('dateCertification')).'</p>
									</div>';
		} else {
			$userCertification =  HtmlSection::show('certification-user');
		}
		return '<div class="sectionFieldsWrapper sectionFieldsWrapperSimple">
					<div class="sectionItem">
						<div class="sectionItemIns">
							<h3 class="titleSection">'.__('site_userCertification').'</h3>
							<div class="sectionPage">
								'.$userCertification.'
							</div>
							<div class="clearer"></div>
						</div>
					</div>
					'.$boatsCertification.'
				</div>';
	}

	public function renderInfoReservation() {
		$info = '';
		$info .= ($this->object->get('experience')!='') ? '<h3>'.__('label_experience').'</h3>
													<p>'.nl2br($this->object->get('experience')).'</p>' : '';
		$info .= ($this->object->get('help')!='') ? '<h3>'.__('label_help').'</h3>
													<p>'.nl2br($this->object->get('help')).'</p>' : '';
		return '<div class="ownerInfo">
					<div class="ownerInfoWrapper">
						<div class="ownerInfoLeft">
							<div class="ownerInfoLeftImage" style="background-image:url('.$this->object->getImageUrl('image', 'square').');"></div>
						</div>
						<div class="ownerInfoRight">
							<div class="ownerName">'.$this->object->get('name').'</div>
							<p>'.__('site_inscription').' <strong>'.Date::textMonth(Date::sqlMonth($this->object->get('created'))).' '.Date::sqlYear($this->object->get('created')).'</strong></p>
						</div>
						<div class="clearer"></div>
					</div>
					'.$this->badges().'
					'.$info.'
				</div>';
	}

	public function badges() {
		$info = '';
		$info .= ($this->object->get('certification')=='1') ? '<div class="badgeUser badgeUser-certification"><span>'.__('label_certification').'</span></div>' : '';
		$info .= ($this->object->get('club')=='1') ? '<div class="badgeUser badgeUser-club"><span>'.__('label_club').'</span></div>' : '';
		return ($info!='') ? '<div class="badgesUser">
									'.$info.'
									<div class="clearer"></div>
								</div>' : '';
	}

	public function renderInfoSimple($options=array()) {
		$title = (isset($options['title'])) ? $options['title'] : __('site_sailor');
		$query = 'SELECT COUNT(*) as numRentals FROM '.Db::prefixTable('Boat, BoatRent').' WHERE '.Db::prefixTable('Boat').'.idBoat='.Db::prefixTable('BoatRent').'.idBoat AND '.Db::prefixTable('Boat').'.idUserSite="'.$this->object->id().'"';
		$numRentals = Db::returnAllColumn($query);
		$numRentals = $numRentals[0];
		return '<div class="itemInfoSimple">
					<div class="itemInfoSimpleTitle">'.$title.'</div>
					<div class="simpleInfo"><strong>'.__('label_name').'</strong> '.$this->object->getBasicInfo().'</div>
					<div class="simpleInfo"><strong>'.__('site_club').'</strong> '.Date::textMonth(Date::sqlMonth($this->object->get('created'))).' '.Date::sqlYear($this->object->get('created')).'</div>
					<div class="simpleInfo"><strong>'.__('site_rentals').'</strong> '.$numRentals.'</div> 
					<div class="clearer"></div>
				</div>';
	}

	public function renderInfoSimpleSailor($options=array()) {
		$title = (isset($options['title'])) ? $options['title'] : __('site_sailor');
		$query = 'SELECT COUNT(*) as numRentals FROM '.Db::prefixTable('Boat, BoatRent').' WHERE '.Db::prefixTable('Boat').'.idBoat='.Db::prefixTable('BoatRent').'.idBoat AND '.Db::prefixTable('Boat').'.idUserSite="'.$this->object->id().'"';
		$numRentals = Db::returnAllColumn($query);
		$numRentals = $numRentals[0];
		$cvMarin = UserSiteCv::readFirst(array('where'=>'idUserSite="'.$this->object->id().'"'));
		$cvMarinBtn = ($cvMarin->id()!='') ? '<div class="simpleInfoLink"><a href="'.url('cvmarin-view/'.$cvMarin->id()).'" target="_blank">'.__('viewCvMarin').'</a></div>' : '';
		return '<div class="itemInfoSimple">
					<div class="itemInfoSimpleTitle">'.$title.'</div>
					<div class="itemInfoSimpleLeft">
						'.$this->object->getImage('image', 'square', '<div class="imageEmptyPerson"></div>').'
					</div>
					<div class="itemInfoSimpleRight">
						<div class="simpleInfo"><strong>'.__('label_name').'</strong> '.$this->object->getBasicInfo().'</div>
						<div class="simpleInfo"><strong>'.__('site_age').'</strong> '.Date::age($this->object->get('birthDate')).'</div>
						<div class="simpleInfo"><strong>'.__('site_inscription').'</strong> '.Date::textMonth(Date::sqlMonth($this->object->get('created'))).' '.Date::sqlYear($this->object->get('created')).'</div>
						<div class="simpleInfo"><strong>'.__('site_rentals').'</strong> '.$numRentals.'</div> 
					</div>
					<div class="clearer"></div>
					'.$cvMarinBtn.'
				</div>';
	}

	public function renderInfoAddress() {
		$address = UserSiteAddress::readFirst(array('where'=>'idUserSite="'.$this->object->id().'"'));
		return '<div class="userInfoAddress">
					<div class="userInfoAddressWrapper">
						<div class="userInfoAddressLeft">
							'.$this->object->getImage('image', 'square', '<div class="imageEmptyPerson"></div>').'
						</div>
						<div class="userInfoAddressRight">
							<h2>'.__('label_sailor').': <strong>'.$this->object->getBasicInfo().'</strong></h2>
							<p>'.__('site_club').' <strong>'.Date::textMonth(Date::sqlMonth($this->object->get('created'))).' '.Date::sqlYear($this->object->get('created')).'</strong></p>
							'.$address->showUi('InfoSimple').'
						</div>
						<div class="clearer"></div>
					</div>
				</div>';
	}

	public function renderInfoEmail($options=array()) {
		return $this->object->getBasicInfo();
	}

	public function renderEmailComplete() {
		$address = UserSiteAddress::readFirst(array('where'=>'idUserSite="'.$this->object->id().'"'));
		return '<h3>'.$this->object->name().'</h3>
				<p><strong><a href="mailto:'.$this->object->get('email').'" target="_blank">'.$this->object->get('email').'</a></strong></p>
				<p>'.$address->showUi('InfoEmail').'</p>';
	}

	public function renderEmail() {
		return '<hr/>
				<p>'.$this->renderEmailItemSimple('image').'</p>
				<p>
				'.$this->renderEmailItemSimple('name').'
				'.$this->renderEmailItemSimple('lastName').'
				'.$this->renderEmailItemSimple('email').'
				'.$this->renderEmailItemSimple('companyName').'
				'.$this->renderEmailItemSimple('siren').'
				'.$this->renderEmailItemSimple('birthDate').'
				'.$this->renderEmailItemSimple('idCountry').'
				'.$this->renderEmailItemSimple('profile').'
				'.$this->renderEmailItemSimple('type').'
				</p>
				<p>
				'.$this->renderEmailItemSimple('experience').'
				'.$this->renderEmailItemSimple('help').'
				'.$this->renderEmailItemSimple('newsletter').'
				</p>
				<hr/>';
	}

}

?>
