<?php
class Init {
	
	static public function initSite(){
		//Initialize the site
		$lang = new Lang();
		$lang->createTable();
		Lang::insertConfig();
		$langTrans = new LangTrans();
		$langTrans->createTable();
		LangTrans::insertConfig();
		$params = new Params();
		$params->createTable();
		Params::insertConfig();
		$userType = new UserType();
		$userType->createTable();
		$userTypeMenu = new UserTypeMenu();
		$userTypeMenu->createTable();
		$user = new User();
		$user->createTable();
		$userTypes = UserType::countResults();
		if ($userTypes==0) {	
			//Initialize default values for User, UserType and UserTypeMenu
			$newUserType = new UserType();
			$newUserType->insert(array('code'=>'superadmin', 'name'=>'Super Admin'));
			$newUser = new User();
			$newUser->insert(array('idUserType'=>$newUserType->id(),
									'name'=>'Super Admin',
									'email'=>EMAIL,
									'password'=>'asterion',
									'active'=>'1'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Pages',
											'name_fr'=>'Pages',
											'name_es'=>'P&aacute;ginas',
											'action'=>'Page',
											'type'=>'0'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Banners',
											'name_fr'=>'Banners',
											'name_es'=>'Banners',
											'action'=>'Banner',
											'type'=>'0'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Posts - Categories',
											'name_fr'=>'Posts - Categories',
											'name_es'=>'Posts - Categorias',
											'action'=>'PostCategory',
											'type'=>'0'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Posts',
											'name_fr'=>'Posts',
											'name_es'=>'Posts',
											'action'=>'Post',
											'type'=>'0'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Email templates',
											'name_fr'=>'Gabarits des emails',
											'name_es'=>'Plantillas de los emails',
											'action'=>'HtmlMailTemplate',
											'type'=>'1'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Emails',
											'name_fr'=>'Emails',
											'name_es'=>'Emails',
											'action'=>'HtmlMail',
											'type'=>'1'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Users',
											'name_fr'=>'Utilisateurs',
											'name_es'=>'Usuarios',
											'action'=>'User',
											'type'=>'1'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'User Types',
											'name_fr'=>'Types d\'utilisateurs',
											'name_es'=>'Tipos de usuarios',
											'action'=>'UserType',
											'type'=>'1'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Site parameters',
											'name_fr'=>'Param&egrave;tres du site',
											'name_es'=>'Par&aacute;metros',
											'action'=>'Params',
											'type'=>'2'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Translations',
											'name_fr'=>'Traductions',
											'name_es'=>'Traducciones',
											'action'=>'LangTrans',
											'type'=>'2'));
			$newUserTypeMenu = new UserTypeMenu();
			$newUserTypeMenu->insert(array('idUserType'=>$newUserType->id(),
											'name_en'=>'Logout',
											'name_fr'=>'D&eacute;connexion',
											'name_es'=>'Salir',
											'action'=>'User/logout',
											'type'=>'3'));
		}
		//Initialize the admin section
		$htmlSectionAdmin = new HtmlSectionAdmin();
		$htmlSectionAdmin->createTable();
		HtmlSectionAdmin::insertConfig();
		//Initialize the email managment section
		$htmlMailTemplate = new HtmlMailTemplate();
		$htmlMailTemplate->createTable();
		HtmlMailTemplate::insertConfig();
		$htmlMail = new HtmlMail();
		$htmlMail->createTable();
		HtmlMail::insertConfig();
	}

}
?>