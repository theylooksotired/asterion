<?php
class Lang_Ui extends Ui{

	protected $object;

	public function __construct (Lang & $object) {
		$this->object = $object;
	}

	static public function showLangs($simple=false) {
		$langActive = Lang::active();
		$html = '';
		foreach (Lang::langLabels() as $lang) {
			$html .= '<div class="lang lang_'.$lang['idLang'].'">';
			$name = ($simple) ? $lang['idLang'] : $lang['name'];
			if ($lang['idLang'] == $langActive) {
				$html .= '<span>'.$name.'</span> ';
			} else {
				$linkLang = Url::urlLang($lang['idLang']);
				$html .= '<a href="'.$linkLang.'">'.$name.'</a> ';
			}
			$html .= '</div>';
		}
		return '<div class="langs">
					'.$html.'
					<div class="clearer"></div>
				</div>';
	}

	static public function showLangsSimple() {
		return Lang::showLangs(true);
	}
	
}
?>