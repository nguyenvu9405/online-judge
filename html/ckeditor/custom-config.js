/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'Title;Heading;Heading2;Normal';
	config.format_Title = {name: 'Title', element: 'div', attributes: {"class":"title"}};
	config.format_Heading = {name:'Heading', element: 'div',attributes: {"class":"heading"}};
    config.format_Heading2 = {name:'Heading 2', element: 'div',attributes: {"class":"heading-2"}};
	config.format_Normal = {name: 'Normal', element: 'p', attributes: {"class":"normal"}};
	//config.format_TableHeader = {name:'Table header',element:'div',attributes:{"class":"table-header"}};

	// Simplify the dialog windows.

    config.extraPlugins = "image2";
    config.extraPlugins = "uploadimage";
	config.imageUploadUrl = "/ckfinder/upload_drag.php?type=image";
	config.filebrowserImageUploadUrl = "/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
    config.filebrowserImageBrowseUrl = "/ckfinder/ckfinder.html";
    config.removeDialogTabs = 'image:advanced;link:advanced';

};
