<?php
class Louis_System_RecursiveMenuAdmin{
	
	protected $_sourceArr;
	public function __construct($sourceArr = null){
		$this->_sourceArr = $sourceArr;
	}
	

	public function buildArrayUl($parents = 0){
		$resultArr = '';
		$this->recursiveMenu($this->_sourceArr,$parents, 1,$resultArr);
		
		return str_replace('<ul></ul>','',$resultArr);
	}
	
	public function getParentsIdArray($id,$options = null){
		if($options['type'] == 1){
			$arrParents[] = $id;
		}
		$this->findParents($this->_sourceArr,$id, $arrParents);
		return $arrParents;
	}
	


	
	public function recursiveMenu($sourceArr, $parents = 0,$level = 1, &$newMenu){
		$paramArray = Zend_Controller_Front::getInstance()->getRequest()->getParams();
	  if(count($sourceArr) > 0){
		 $newMenu .= '<ol class="dd-list">';
		  foreach($sourceArr as $key => $value){
			  if($value['parent'] == $parents){
				  $value['level'] = $level;
				  $status = $value['isHome'];
				  $icon_status = '';	
				  $title_status = '';
				  if($status === 'Yes'){
					  $icon_status = 'fa fa-eye bigger-130 blue';
					  $title_status = "Tắt chức năng hiển thị";
				  }else{
					  $icon_status = 'fa fa-eye-slash bigger-130 blue';
					  $title_status = "Bật chức năng hiển thị";
				  }
				 
				 $newMenu .= '<li data-id="'.$value['id'].'" class="dd-item item-'.(($level == 1)?'orange':'blue2').'" id="sort_'.$value['id'].'">';
				$newMenu .= '<div class="dd-handle">'. $value['name'].'</br>';
				$newMenu .= '<span style="font-size:0.9em;color:#848484 !important">http://'.$_SERVER['HTTP_HOST'].DIRECTORY_SEPARATOR.(($value['link_folder'] == "")?"":$value['link_folder'] . DIRECTORY_SEPARATOR ). $value['link'].'</span>';
				$newMenu .=  '<div class="pull-right action-buttons">';
				$newMenu .= '<a href="/admin/menuitem/image/id/'.$value['id'].'/menu/'.$value['menu_id'].'"><i class="fa fa-picture-o bigger-130 orange"></i></a>';
				$newMenu .= '<a style="cursor:pointer;" id="status_'.$value["id"].'" onClick="toggle_status(this);" title="'.$title_status.'"><i class="'.$icon_status.'"></i></a>';
				$newMenu .=  '<a class="green" href="/admin/menuitem/update/id/'.$value['id'].'"><i class="fa fa-pencil bigger-130"></i></a><a onclick="return confirm(\'Bạn muốn xóa?\');" class="red" href="/admin/menuitem/delete/id/'.$value["id"].'"><i class="fa fa-trash bigger-130"></i></a></div></div>';
				 $newParents = $value['id'];
				 unset($sourceArr[$key]);	
				 if ($this->isSub($newParents) == 1){
				  $this->recursiveMenu($sourceArr, $newParents, $level + 1, $newMenu);
				  }
				$newMenu .= '</li>';
			  }
		  }
	
		   $newMenu .= '</ol>';
	  }
	}
	/*
	public function recursiveSubMenu($sourceArr, $parents = 0,$level = 1, &$newMenu){
	  if(count($sourceArr) > 0){
				 $newMenu .= '<ul class="icesubMenu icemodules sub_level_'.$level.'" style="width:280px">';
				 $newMenu .= '<li>';
				 $newMenu .= '<div class="iceCols" style="float:left;width:280px">';
				  $newMenu .= '<ul>';
		  foreach($sourceArr as $key => $value){
			  if($value['parent'] == $parents){
				  $value['level'] = $level;
				 $newMenu .= '<li class="iceMenuLiLevel_'.$level.' '.(($this->isSub($value['id']) == 1)?"parent":"").'"><a class="iceMenuTitle" href="/'. $value['link']  .'"><span class="icemega_title">'. $value['name'] .'</span></a>';
				 $newParents = $value['id'];
				 unset($sourceArr[$key]);	
				 if ($this->isSub($newParents) == 1){	
				 $this->recursiveSubMenu($sourceArr, $newParents, $level + 1, $newMenu);
				 }
				$newMenu .= '</li>';
			  }
		  }
		  $newMenu .= '</ul>';
		  $newMenu .= '</div>';
		   $newMenu .= '</li>';
		  $newMenu .= '</ul>';
	  }
	}

	*/
	public function findParents($sourceArr,$id, &$arrParents){
			foreach ($sourceArr as $key => $value){		
				if($value['id'] == $id){
					if( $value['parent'] >0 ){
						$arrParents[] = $value['parent'];
						unset($sourceArr[$key]);
						$newID = $value['parent'];
						$this->findParents($sourceArr,$newID, $arrParents);
					}
				}
			}
		}
		
	public function isSub($parent){
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = 'select id from menu_items where parent = '.$parent;
		$result = $db->fetchRow($sql);
		if(count($result['id']) > 0){
			return 1;
		}else {
			return 0;
		}
	}
	
}