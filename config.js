CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbar = 'bpckeditor';
	
	config.toolbar_bpckeditor =
	[
	    ['Source'],
	    ['Cut','Copy','Paste','PasteText','PasteFromWord'],
	    ['Undo','Redo','-','Find','Replace','-','SelectAll','ShowBlocks','RemoveFormat'],
	    ['Image','Table','HorizontalRule','SpecialChar'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['Link','Unlink','Anchor'],
	    '/',
	    ['Styles','Format','Font','FontSize'],
	    ['TextColor','BGColor'],['Scayt'],
	];
};
