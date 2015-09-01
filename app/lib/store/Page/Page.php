<?php
class Page extends Db_Object {

	public function __construct($VALUES=array()) {
		parent::__construct($VALUES);
	}

	static public function code($code) {
		return Page::readFirst(array('where'=>'code="'.$code.'"'));
	}

	static public function show($code) {
		$page = Page::code($code);
		return '<div class="pageSimple">'.$page->get('description').'</div>';
	}

}
?>