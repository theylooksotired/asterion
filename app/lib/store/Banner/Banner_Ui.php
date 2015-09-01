<?php
class Banner_Ui extends Ui{

	protected $object;

	public function __construct (Banner & $object) {
		$this->object = $object;
	}

	public function renderPublic($options=array()) {
		$title = ($this->object->get('link')!='') ? '<a href="'.Url::format($this->object->get('link')).'">'.$this->object->getBasicInfo().'</a>' : $this->object->getBasicInfo();
		return '<div class="banner">
					<div class="bannerIns">
						<div class="bannerImage" style="background-image:url('.$this->object->getImageUrl('image', 'huge').');"></div>
						<div class="bannerInfo">
							<div class="bannerInfoTitle">'.$title.'</div>
							<div class="bannerInfoDescription">'.nl2br($this->object->get('description')).'</div>
						</div>
					</div>
				</div>';
	}

}
?>