<?php
class Zend_Controller_Action_Helper_Recursive extends
Zend_Controller_Action_Helper_Abstract
{
public function direct($menu, $parent = 0) {
	$stt = 0;
	$db = Zend_Db_Table::getDefaultAdapter();

	foreach($menu as $k=>$v): $stt++;
	$update = "update menu_items set position = $stt where id = '".$v['id']."'";
	$update2 = "update menu_items set parent = $parent where id = '".$v['id']."'";
	$db->query($update);
	$db->query($update2);
	if(isset($v['children']))
	{
		$this->direct($v['children'], $v['id']);
	}
	
	endforeach;
	
	}
	

}