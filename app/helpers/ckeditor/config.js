/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	var appUrl = info_site.base_url;

	config.filebrowserBrowseUrl = appUrl + 'app/helpers/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = appUrl + 'app/helpers/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = appUrl + 'app/helpers/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = appUrl + 'app/helpers/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = appUrl + 'app/helpers/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = appUrl + 'app/helpers/kcfinder/upload.php?type=flash';
	config.height = 450;
	config.allowedContent = true;
};
