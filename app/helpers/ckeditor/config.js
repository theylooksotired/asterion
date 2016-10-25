/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	var appUrl = info_site.base_url;
	var siteUrl = info_site.app_folder;
	config.filebrowserBrowseUrl = appUrl + 'app/helpers/kcfinder/browse.php?type=files&site='+siteUrl;
	config.filebrowserImageBrowseUrl = appUrl + 'app/helpers/kcfinder/browse.php?type=images&site='+siteUrl;
	config.filebrowserFlashBrowseUrl = appUrl + 'app/helpers/kcfinder/browse.php?type=flash&site='+siteUrl;
	config.filebrowserUploadUrl = appUrl + 'app/helpers/kcfinder/upload.php?type=files&site='+siteUrl;
	config.filebrowserImageUploadUrl = appUrl + 'app/helpers/kcfinder/upload.php?type=images&site='+siteUrl;
	config.filebrowserFlashUploadUrl = appUrl + 'app/helpers/kcfinder/upload.php?type=flash&site='+siteUrl;
	config.height = 450;
	config.allowedContent = true;
};
