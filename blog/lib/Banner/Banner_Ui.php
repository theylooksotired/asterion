<?php
/**
* @class BannerUi
*
* This class manages the UI for the Banner objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Banner_Ui extends Ui{

	/**
	* Render the banner.
	*/
	public function renderPublic() {
		$html = '<div class="bannerImage" style="background-image:url('.$this->object->getImageUrl('image', 'huge').');">
					<div class="bannerInfo">
						<h2>'.$this->object->getBasicInfo().'</h2>
						'.$this->object->get('description').'
					</div>
				</div>';
		$link = $this->object->urlLink('link');
		$html = ($link!='') ? '<a href="'.$link.'">'.$html.'</a>' : $html;
		return '<div class="banner">'.$html.'</div>';
	}

	/**
	* Render the intro banners.
	*/
	static public function intro() {
		$items = new ListObjects('Banner', array('where'=>'idLang="'.Lang::active().'"',
												'order'=>'ord'));
		if (!$items->isEmpty()) {
			return '<div class="banners">'.$items->showList().'</div>';
		}
	}

}
?>