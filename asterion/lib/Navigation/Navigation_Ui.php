<?php
class Navigation_Ui extends Ui {

	public function render() {
		$layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
		$title = (isset($this->object->titlePage)) ? '<h1>'.$this->object->titlePage.'</h1>' : '';
		$message = (isset($this->object->message)) ? '<div class="message">'.$this->object->message.'</div>' : '';
		$messageError = (isset($this->object->messageError)) ? '<div class="message messageError">'.$this->object->messageError.'</div>' : '';
		$content = (isset($this->object->content)) ? $this->object->content : '';
		switch ($layoutPage) {
			default:
				return '<div class="contentWrapper">
							'.$this->header().'
							'.$this->menu().'
							<div class="content">'.$content.'</div>
							'.$this->footer().'
						</div>';
			break;
		}
	}

	public function header() {
		return '<div class="header">
					<div class="headerIns">
						<div class="headerLeft">
							<div class="logo">
								<a href="'.url('').'">'.Params::param('titlePage').'</a>
							</div>
						</div>
						<div class="headerRight">
							'.$this->shareIcons().'
							'.$this->search().'
						</div>
						<div class="clearer"></div>
					</div>
				</div>';
	}

	public function footer() {
		return '<div class="footer">
					<div class="footerIns">
						<div class="footerLeft">
							'.$this->shareIcons().'
						</div>
						<div class="footerRight">
							'.Page::show('footer').'
						</div>
						<div class="clearer"></div>
					</div>
				</div>';
	}

	public function shareIcons() {
		return '<div class="shareIcons">
					<div class="shareIcon shareIconFacebook">
						<a href="'.url('facebook').'" target="_blank">Facebook</a>
					</div>
					<div class="shareIcon shareIconTwitter">
						<a href="'.url('twitter').'" target="_blank">Twitter</a>
					</div>
					<div class="shareIcon shareIconYoutube">
						<a href="'.url('youtube').'" target="_blank">Youtube</a>
					</div>
					<div class="shareIcon shareIconLinkedIn">
						<a href="'.url('linkedin').'" target="_blank">LinkedIn</a>
					</div>
					<div class="clearer"></div>
				</div>';
	}

	public function menu() {
		return '<div class="menu">
					<div class="menuIns">
						<a href="">Menu item 1</a>
					</div>
					<div class="menuIns">
						<a href="">Menu item 2</a>
					</div>
					<div class="menuIns">
						<a href="">Menu item 3</a>
					</div>
					<div class="clearer"></div>
				</div>';
	}

	public function search() {
		return '<div class="searchTop">
					<form action="'.url('search').'" method="post" enctype="multipart/form-data" class="formSearch" accept-charset="UTF-8">
						<fieldset>
							<div class="text formField">
								<input type="text" name="search" size="50"/>
								<div class="clearer"></div>
							</div>
							<div class="formFieldSubmit">
								<input type="submit" value="'.__('search').'" class="formSubmit"/>
							</div>
							<div class="clearer"></div>
						</fieldset>
					</form>
				</div>';
	}

}
?>