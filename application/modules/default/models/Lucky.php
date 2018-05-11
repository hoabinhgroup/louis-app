<?php
class Model_Lucky extends Louis_Db_Table_Abstract 
     {
       protected $_name    = 'lucky';
       protected $_primary  = 'id';
       protected $_db;
       
	   public function init()
	   {
		   parent::init();
	   }
		
		function get_details($options = array()) {

       
        $select = $this->_db->select()
        					->from(array('l' => $this->_name))
        					->joinInner(array('u' => 'users'), "l.user_id = u.id", array('name','is_work'));
        							
        					        					
        $id = $this->get_array_value($options, "id");
        if ($id) {
            $select->where('l.id = ?', $id);
        }   
        
         					        					
        $adward = $this->get_array_value($options, "adward");
        if ($adward) {
            $select->where('l.adward = ?', $adward);
        }else{
	       $select->where('l.adward = ?', '0'); 
        }
               				
       	$result = $this->_db->fetchAll($select);	
       	
       	if(count($result) > 0) {
                return $result;
            }else{
                return null;
            }				
    }
    
    	public function getLucky()
    	{
	    	 $select = $this->_db->select()
        					->from(array('l' => $this->_name), array('user_id'));
        					
			$result = $this->_db->fetchAll($select);	
			$userIDs = array();
			foreach($result as $key=>$val):
				$userIDs[] = $val['user_id'];
			endforeach;
			return array_unique($userIDs);
       	    					 
    	}
    	
    	     public function getCountLuckyAdward($adward)
    	{
	    	 $select = $this->_db->select()
        					->from(array('l' => $this->_name), array('user_id'))
        					->where("l.adward = ?", $adward);
        					
			$result = $this->_db->fetchAll($select);	
			$count = count($result);
			return $count;
       	    					 
    	}

    	
    	public function getUser()
    	{
	    	 $select = $this->_db->select()
        					->from(array('u' => 'users'), array('id','name','code'));
        			if(count($this->getLucky()) > '0'):		
			$select->where("u.id NOT IN (?)", $this->getLucky());
					endif;
							//->group('u.id');
			$result = $this->_db->fetchAll($select);	
       	
				if(count($result) > 0) {
                return $result;
            }else{
                return null;
            }	
    	}


   }