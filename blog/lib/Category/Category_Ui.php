<?php
/**
* @class CategoryUi
*
* This class manages the UI for the Category objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Category_Ui extends Ui{

	/**
	* Render the category public view.
	*/
	public function renderPublic() {
		$count = Post::countResults(array('where'=>'idCategory="'.$this->object->id().'" AND active="1"'));
		return '<div class="itemPublic itemPublicCategory">
					<a href="'.$this->object->url().'">
						<h2>'.$this->object->getBasicInfo().'</h2>
						<p><em>'.$count.' '.__('posts').'</em></p>
						<p>'.$this->object->get('shortDescription').'</p>
					</a>
				</div>';
	}

	/**
	* Render the complete category which is the list of categories.
	*/
	public function renderComplete() {
		$items = new ListObjects('Post', array('where'=>'idCategory="'.$this->object->id().'" AND active="1"',
												'order'=>'publishDate DESC',
												'results'=>'5'));
		return '<div class="listPublic listPublicCategory">
					'.$items->showListPager(array('function'=>'Public')).'
				</div>';
	}

	/**
	* Render the intro list of categories.
	*/
	static public function intro() {
		$items = new ListObjects('Category', array('order'=>'ord'));
		return '<div class="listPublic listPublicIntro">
					'.$items->showListPager(array('showResults'=>false)).'
				</div>';
	}

}
?>