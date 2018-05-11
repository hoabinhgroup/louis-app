<?php
class Zend_Controller_Action_Helper_Content extends
Zend_Controller_Action_Helper_Abstract
{
	public function direct() 
		{
		

		}

	public function insert($parents = array(), $pid)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
           foreach ($parents as $key=>$val):
          $insert = 'INSERT INTO product_relationships (object_id, category_id) 
          				VALUES ("'.$pid.'", "'.$val.'" )';
		  $db->query($insert);
          endforeach;
	}
	
	
	public function get_array_value(array $array, $key) {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
    }
    
    public function js_anchor($title = '', $attributes = '', $href="#") {
        $title = (string) $title;
        $html_attributes = "";

        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $html_attributes .= ' ' . $key . '="' . $value . '"';
            }
        }

        return '<a href="'.$href.'"' . $html_attributes . '>' . $title . '</a>';
    }
    
    public function get_icon_communication($data_communication)
    {
	    $com_arr = explode(',',$data_communication);
					$icon = '';
			foreach($com_arr as $val):
				    $icon.= ($val == 'car')?'<i class="fa fa-bus" aria-hidden="true"></i>':'';
				    $icon.= ($val == 'train')?' <i class="fa fa-train" aria-hidden="true"></i>':'';
				    $icon.= ($val == 'plane')?' <i class="fa fa-plane" aria-hidden="true"></i>':'';
				    $icon.= ($val == 'bike')?' <i class="fa fa-bicycle" aria-hidden="true"></i>':'';
				    $icon.= ($val == 'cruise')?' <i class="fa fa-ship" aria-hidden="true"></i>':'';
			endforeach;
			
		return $icon;
    }

	public function convert_time_travel($data_timetravel)
	{
		$time_travel = explode('.',$data_timetravel);
				if(!isset($time_travel[1])){
						$dem = '';
					}else{
						$dem = $time_travel[1]. ' đêm';
					}
		return $time_travel[0]. ' ngày '. $dem;
	}
	
	
	public function super_unique($array)
{
  $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

  foreach ($result as $key => $value)
  {
    if ( is_array($value) )
    {
      $result[$key] = $this->super_unique($value);
    }
  }

  return $result;
}

}