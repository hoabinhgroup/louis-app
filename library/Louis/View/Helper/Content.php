<?php
class Louis_View_Helper_Content extends Zend_View_Helper_Abstract{
        
       public function content()
		 {
			 return $this;
		 }
		 
	  public function createBreadcrum($id, $menu_id, $link_folder = '/') {
		$db = Zend_Db_Table::getDefaultAdapter();
    $s = "SELECT * FROM menu_items WHERE menu_id = '".$menu_id."' and id = '".$id."'";
    $row = $db->fetchRow($s);

    if($row['parent'] == 0) {
        return '<li> <a href="'.$link_folder .$row['link'].'">'.$row['name'].'</a> </li>';
    } else {
        return $this->createBreadcrum($row['parent'], $menu_id, $link_folder).' <li> <a href="'. $link_folder . $row['link'].'">'.$row['name'].'</a> </li>';
      }
          }		

		  public function getUsernameFB($uid){
    $url = "http://graph.facebook.com/".$uid;
	$res = json_decode( file_get_contents( $url ));
	
	return $res;
	}
	
	
		public function check_in_arr($string, $param) {
        $arr = explode(",",$string);
        if (in_array($param, $arr))
		{
			return ' checked';
  		}
  		  else
  			{
  			return '';
  			}
  		} 


    } 