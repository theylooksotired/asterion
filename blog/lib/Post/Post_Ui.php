<?php
/**
* @class PostUi
*
* This class manages the UI for the Post objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Post_Ui extends Ui{

	/**
	* Render the post.
	*/
	public function renderPublic() {
		return '<div class="itemPublic itemPublicPost">
					<a href="'.$this->object->url().'">
						<h2>'.$this->object->getBasicInfo().'</h2>
						'.$this->object->getImage('image', 'thumb').'
						<p><em>'.Date::sqlText($this->object->get('publishDate')).'</em></p>
						<p>'.$this->object->get('shortDescription').'</p>
					</a>
				</div>';
	}

	/**
	* Render the post on the sidebar.
	*/
	public function renderSide() {
		return '<div class="itemSide itemSidePost">
					<a href="'.$this->object->url().'">
						<h3>'.$this->object->getBasicInfo().'</h3>
						'.$this->object->getImage('image', 'thumb').'
						<p>'.$this->object->get('shortDescription').'</p>
					</a>
				</div>';
	}

	/**
	* Render the complete post.
	*/
	public function renderComplete() {
		$this->object->modifySimple('views', intval($this->object->get('views'))+1);
		return '<div class="itemComplete itemCompletePost">
					<div class="postTop">
						<div class="postTopLeft">
							'.$this->object->getImage('image', 'web').'
						</div>
						<div class="postTopRight">
							<p><em>'.Date::sqlText($this->object->get('publishDate')).'</em></p>
							<p><strong>'.$this->object->get('shortDescription').'</strong></p>
						</div>
					</div>
					<div class="postContent pageComplete">
						'.$this->object->get('description').'
					</div>
				</div>';
	}

	/**
	* Render the intro list of posts.
	*/
	static public function intro() {
		$items = new ListObjects('Post', array('where'=>'active="1"',
												'results'=>'5',
												'order'=>'created DESC'));
		return '<div class="listPublic listPublicIntro">
					'.$items->showListPager().'
				</div>';
	}

	/**
	* Render the list of the 3 latest posts.
	*/
	static public function latest() {
		$items = new ListObjects('Post', array('where'=>'active="1"',
												'order'=>'created DESC',
												'limit'=>'3'));
		if (!$items->isEmpty()) {
			return '<h2>'.__('latestPosts').'</h2>
					<div class="itemsSide">
						'.$items->showList(array('function'=>'Side')).'
					</div>';
		}
	}

	/**
	* Render the list of the 3 most popular posts.
	*/
	static public function popular() {
		$items = new ListObjects('Post', array('fields'=>'*',
												'where'=>'active="1"',
												'order'=>'views DESC',
												'limit'=>'3'));
		if (!$items->isEmpty()) {
			return '<h2>'.__('popularPosts').'</h2>
					<div class="itemsSide">
						'.$items->showList(array('function'=>'Side')).'
					</div>';
		}
	}

}
?>