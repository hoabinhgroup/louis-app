<?php
class Zend_Controller_Action_Helper_Cache extends
Zend_Controller_Action_Helper_Abstract
{
	public function direct($dir) {

  if($handle = opendir("$dir")){
    while (false !== ($item = readdir($handle))){
     if($item != "." && $item != ".."){
       if(is_dir("$dir/$item")){
         remove_directory("$dir/$item");
       }else{
     unlink("$dir/$item");
     //echo"removing $dir/$item<br>\n";
     }
   }
  }
   closedir($handle);
 }

}

}