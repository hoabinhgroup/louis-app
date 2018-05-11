<?php
class Louis_System_RecursiveMenu{
	
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
		  $link = '';
		  $icon = '';
		  
		  if($level > 1){
			   $newMenu .= '<ul class="dropdown-menu">';
		  }else {
				$newMenu .= '<ul class="nav navbar-nav">';
		 	}
		  foreach($sourceArr as $key => $value){
			  if($value['parent'] == $parents){
				  $value['level'] = $level;	
		
				 $newParents = $value['id'];
				 
			 if ($this->isSub($newParents) == 1){
				$link = "class='dropdown-toggle' data-toggle='dropdown'"; 
			    $icon = "<b class='caret'></b>";
				 }
				
		
	 $newMenu .= '<li><a '.$link.' href="'. $value['link']  .'">'. $value['name'] .$icon.'</a>';

				
				 unset($sourceArr[$key]);	
				  $this->recursiveMenu($sourceArr, $newParents, $level + 1, $newMenu);				  
				$newMenu .= '</li>';
			  }
		  }
	
		  $newMenu .= '</ul>';
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