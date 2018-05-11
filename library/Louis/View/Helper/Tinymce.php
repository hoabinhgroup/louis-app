<?php
class Louis_View_Helper_Tinymce extends Zend_View_Helper_Abstract{
        public function Tinymce(){
        
           
                return "<script>tinymce.init({
                selector:'textarea',
                plugins: [
		'advlist autolink lists link image charmap print preview anchor',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table contextmenu paste filemanager textcolor'
	],
	toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | styleselect formatselect fontselect fontsizeselect | forecolor backcolor',
	entity_encoding : 'raw',
	relative_urls: false,
	external_filemanager_path:'/public/scripts/tinymce/plugins/filemanager/filemanager/',
	filemanager_title:'Quản lý file upload' ,
	external_plugins: { 'filemanager' : '/public/scripts/tinymce/plugins/filemanager/plugin.min.js'},
	height: 350	
                });</script>";
             
        }
    } 