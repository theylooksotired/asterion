<?php
class HtmlSection extends Db_Object {

	public function __construct($VALUES=array()) {
		parent::__construct($VALUES);
	}

	static public function code($code) {
		return HtmlSection::readFirst(array('where'=>'code="'.$code.'"'));
	}

	static public function show($code) {
		$html = HtmlSection::code($code);
		return $html->showUi('Page');
	}

}
?>