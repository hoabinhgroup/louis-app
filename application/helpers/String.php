<?php
class Zend_Controller_Action_Helper_String extends
Zend_Controller_Action_Helper_Abstract
{
public function direct($strvncodau,$thaythekhoangtrang) {

	$strvncodau = str_replace(
		array(' ','+','%',"/","\\",'"','?','<','>',"#","^","`","'","=","!",":" ,",,","..","*","&","__","▄","&!","(",")","."),
		array('-','','' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'-','' ,'-','' ,'' ,'' , "_" , " - " ,"" ,"","","","","-"),
		$strvncodau);

	$chars = array("a","A","e","E","o","O","u","U","i","I","d", "D","y","Y");

	$uni[0] = array("á","à","ạ","ả","ã","â","ấ","ầ", "ậ","ẩ","ẫ","ă","ắ","ằ","ặ","ẳ","� �");
	$uni[1] = array("Á","À","Ạ","Ả","Ã","Â","Ấ","Ầ", "Ậ","Ẩ","Ẫ","Ă","Ắ","Ằ","Ặ","Ẳ","� �");
	$uni[2] = array("é","è","ẹ","ẻ","ẽ","ê","ế","ề" ,"ệ","ể","ễ");
	$uni[3] = array("É","È","Ẹ","Ẻ","Ẽ","Ê","Ế","Ề" ,"Ệ","Ể","Ễ");
	$uni[4] = array("ó","ò","ọ","ỏ","õ","ô","ố","ồ", "ộ","ổ","ỗ","ơ","ớ","ờ","ợ","ở","� �");
	$uni[5] = array("Ó","Ò","Ọ","Ỏ","Õ","Ô","Ố","Ồ", "Ộ","Ổ","Ỗ","Ơ","Ớ","Ờ","Ợ","Ở","� �");
	$uni[6] = array("ú","ù","ụ","ủ","ũ","ư","ứ","ừ", "ự","ử","ữ");
	$uni[7] = array("Ú","Ù","Ụ","Ủ","Ũ","Ư","Ứ","Ừ", "Ự","Ử","Ữ");
	$uni[8] = array("í","ì","ị","ỉ","ĩ");
	$uni[9] = array("Í","Ì","Ị","Ỉ","Ĩ");
	$uni[10] = array("đ");
	$uni[11] = array("Đ");
	$uni[12] = array("ý","ỳ","ỵ","ỷ","ỹ");
	$uni[13] = array("Ý","Ỳ","Ỵ","Ỷ","Ỹ");

	for($i=0; $i<=13; $i++) {
		$strvncodau = str_replace($uni[$i],$chars[$i],$strvncodau);
	}

	return strtolower($strvncodau);
}

 public function cut_string($str,$len,$more)
		   {
    if ($str=="" || $str==NULL) return $str;
    if (is_array($str)) return $str;
    $str = trim($str);
    if (strlen($str) <= $len) return $str;
    $str = substr($str,0,$len);
    if ($str != "")
    {
        if (!substr_count($str," "))
        {
            if ($more) $str .= "...";
            return $str;
        }
        while(strlen($str) && ($str[strlen($str)-1] != " "))
        {
            $str = substr($str,0,-1);
        }
        $str = substr($str,0,-1);
        if ($more) $str .= "...";
    }
    return $str;
}

	public function time_travel($string){
		$arrString = explode('.', $string);
		$count = count($arrString);
		if($count < 2){
		return 'Full day ';	
		}
		return $arrString[0].' days '.$arrString[1].' nights ';
	}

}