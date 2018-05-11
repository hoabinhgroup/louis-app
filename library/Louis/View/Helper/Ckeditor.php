<?php
class Louis_View_Helper_Ckeditor extends Zend_View_Helper_Abstract{
        public function Ckeditor($name, $height = 348, $width = 900){
        
            if(isset($name)){
                return "<script>CKEDITOR.replace('".$name."',{
            height: '".$height."',
            width: '".$width."',
            filebrowserBrowseUrl : '/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
	filebrowserUploadUrl : '/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
	filebrowserImageBrowseUrl : '/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
			});</script>";
            }    
        }
    } 