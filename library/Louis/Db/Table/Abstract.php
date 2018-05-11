<?php
class Louis_Db_Table_Abstract extends Zend_Db_Table_Abstract 
     {
	    protected $_db;
	     
	    public function __construct(){
	   $this->_db = Zend_Registry::get('db');
		}
	   
	   
	   public function get_array_value(array $array, $key)
	   {
		   if (array_key_exists($key, $array)) {
            return $array[$key];
        }
	   }  
	   
	   public function get_one($id = 0) {
       return $this->fetchRow($this->select()->where('id = ?', $id));
    	}
    	

    	public function get_one_where($where = array()) {
		$select = $this->select();
		foreach($where as $key=>$val):
		$select->where("$key = ?", $val);
		endforeach;
        $items = $this->fetchRow($select);
       return $items;
       
    
    	}
    	
    	public function truncate()
    	{
	    	$this->getAdapter()->query('TRUNCATE TABLE '.$this->info(Zend_Db_Table::NAME));
    	}
    	
    	  public function update_where($data, array $arrs)
        {
	        $where = array();
		 	foreach($arrs as $key => $val):
		 	 $where[] = $this->getAdapter()->quoteInto("$key = ?", $val); 
		 	endforeach;
		 	return $this->update($data, $where);
        }
        
              public function delete_where(array $arrs)
        {
	        $where = array();
	        foreach($arrs as $key => $val):
	        $where[] = $this->getAdapter()->quoteInto("$key = ?", $val);
	        endforeach;
			return $this->delete($where);
        }
        
        
		   public function save($data = array(), $id = null)
	   {
		   if($id != null)
		   {
		 $where = array("id" => $id);	
		 
		 $success = $this->update_where($data, $where);
		    }else {
		   	 $row = $this->createRow();
			   foreach($data as $key=>$val):
			   $row->$key = $val;
			   endforeach;   	
	   		   $success = $row->save();
		   }
		   
		   return $success;
	  
	   
	   }
	   
	   
	   

	     
	  public function getCount()
	   {
		  return count($this->fetchAll($this->select()));
	   } 
	   

	     
	  }