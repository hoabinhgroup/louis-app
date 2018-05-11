<?php
class Louis_View_Helper_Select extends Zend_View_Helper_Abstract{
        

	  public function Select($name, $value = null, $options, $attribs = array()){
	 	$strAttribs = '';
	  if(count($attribs) > 0){
		  foreach($attribs as $key =>$val){
			  $strAttribs .= $key.' = "'. $val . '"';
		  }
	  }
	 
		$xhtml = '<select name="'.$name.'" id="'.$name.'" '.$strAttribs.'>';
		 foreach($options as $key=>$info):
		 $strSelect = '';
		 	if ($info['id'] == $value){
			 $strSelect = ' selected="selected"';
			 }
			  if($info['level'] == 1){ 
	     $xhtml .='<option label="'.$info['name'].'" value="'.$info['id'].'" '.$strSelect.'>+'.$info['name'].'</option>';
	    }else{ 
		$string = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$newString = '';
		for($i = 1;$i<$info['level'];$i++){
		  $newString .= $string;	
		}
		$info['name'] = $newString . '-' . $info['name'];
	 $xhtml .=' <option label="'.$info['name'].'" value="'.$info['id'].'" '.$strSelect.'>'.$info['name'].'</option>';
	  } 
	   endforeach; 
	   $xhtml .= '</select>'; 
	return $xhtml;
	 }
		 
	
    } 