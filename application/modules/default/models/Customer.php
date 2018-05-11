<?php
class Model_Customer extends Louis_Db_Table_Abstract 
     {
       protected $_name    = 'users';
       protected $_primary  = 'id';
       protected $_db;
       
	   public function init()
	   {
		   parent::init();
	   }
		
		function get_details($options = array()) {

       
        $select = $this->_db->select()
        					->from(array('u' => $this->_name));
        							
        					        					
        $id = $this->get_array_value($options, "id");
        if ($id) {
            $select->where('u.id = ?', $id);
        }   
        
         
        
          $search_input = $this->get_array_value($options, "search_input");
        if ($search_input) {
            $select->where('u.name LIKE ?', "%{$search_input}%");
            $select->orWhere('u.code LIKE ?', "%{$search_input}%");
            $select->orWhere('u.job LIKE ?', "%{$search_input}%");
        }   
        
        
        
        
         $page = $this->get_array_value($options, "page");
        if ($page) {
	      // $page = $this->get_array_value($options, "page");
	        $per_page = 20;
			// $page = ($page - 1) * $per_page;
           $select->limitPage($page, $per_page);
           }
               				
       	$result = $this->_db->fetchAll($select);	
       	
       	if(count($result) > 0) {
                return $result;
            }else{
                return null;
            }				
    }
    
    	
   }