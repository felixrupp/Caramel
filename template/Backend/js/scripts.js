$(document).ready(function(){
	
	//collapseFieldsets();
	
	registerCkeditorConfig();
	
	$(".ckContent").ckeditor(
			function() { // Callback function
				// nothing done here
			},
			{ // Options
				width: "700px",
				toolbar: "Caramel",
				stylesSet: "caramel"
			}
	);
	
});


function collapseFieldsets() {
	
	//$(".collapsableFieldset").siblings().hide();
		
	$(".collapsableFieldset").click(function() {
		$(this).siblings().toggle();
		return false;
	});
	
}


function registerCkeditorConfig() {
	
	CKEDITOR.config.toolbar_Caramel =
		[
			{ name: 'document',		items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
			{ name: 'clipboard',	items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'editing',		items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
			/*{ name: 'forms',		items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },*/
			'/',
			{ name: 'basicstyles',	items : [ 'Bold','Italic','Underline','-','RemoveFormat' ] },
			{ name: 'paragraph',	items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
			{ name: 'links',		items : [ 'Link','Unlink','Anchor' ] },
			{ name: 'insert',		items : [ 'Image','Table','HorizontalRule','SpecialChar','PageBreak' ] },
			'/',
			{ name: 'styles',		items : [ 'Styles','Format', ] },
			{ name: 'colors',		items : [ 'TextColor' ] },
			/*{ name: 'tools',		items : [ 'Maximize', 'ShowBlocks','-','About' ] }*/
		];
	
	CKEDITOR.stylesSet.add('caramel',
		[
		 	// Block-level styles
		 	/*{ name : 'Blue Title', element : 'h2', styles : { 'color' : 'Blue' } },
		 	{ name : 'Red Title' , element : 'h3', styles : { 'color' : 'Red' } },*/
			 
		 	// Inline styles
		 	{ name : 'CSS Style', element : 'span', attributes : { 'class' : 'my_style' } },
		 	{ name : 'Marker: Yellow', element : 'span', styles : { 'background-color' : 'Yellow' } }
		 ]);
}