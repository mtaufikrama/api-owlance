/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

//CKEDITOR.editorConfig = function( config )
//{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
//};

  CKEDITOR.editorConfig = function( config )
   {
      config.removePlugins =  'elementspath,enterkey,entities,forms,pastefromword,htmldataprocessor,specialchar,horizontalrule,wsc' ;
       CKEDITOR.config.toolbar = [
       ['Source','-','Styles','Format','Font','FontSize','Bold','Italic','Underline','Cut','Copy','Paste'],
		'/',
		['-','Outdent','Indent','-','NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Table'],
		  ['Image']
    ] ;

    };


    
	//CKEDITOR.editorConfig = function( config )
  // {
     // config.removePlugins =  'elementspath,enterkey,entities,forms,pastefromword,htmldataprocessor,specialchar,horizontalrule,wsc' ;
     // config.skin = 'v2';
      // CKEDITOR.config.toolbar = [
      // ['Styles','Format','Font','FontSize'],
      // '/',
      // ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
     //  '/',
      // ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
     //  ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
   // ] ;

  //  };
