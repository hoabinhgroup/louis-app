<?php 
class Louis_System_Acl{
	
	protected $_acl;
	
	protected $_role;
	
	public function __construct($aclInfo = null, $options = null){
		//$acl = new Zend_Acl();
		
		//$acl->isAllowed($role, $resource, $privilege);
		if(!empty($aclInfo)){
			$acl = new Zend_Acl();
			$this->_role = $aclInfo['role'];
			$acl->addRole(new Zend_Acl_Role($this->_role));
			
			$groupPrivileges = $aclInfo['privileges'];
			
			$acl->allow($this->_role,null, $groupPrivileges);
			$this->_acl = $acl;
		}
	}
	
	
	public function isAllowed($arrParam = null){
		$ns = new Zend_Session_Namespace('info');
		$nsInfo = $ns->getIterator();
		$privilege = $arrParam['module'] . '_' . $arrParam['controller'] . '_' . $arrParam['action']; 
		$flagAccess = false;
		if($this->_acl->isAllowed($this->_role,null,$privilege)){
			$flagAccess = true;
		}
		
		return $flagAccess;
		
	}
	
	public function createPrivilegeArray($options = null)
	{
		 $ns = new Zend_Session_Namespace('info');
		
		 	
		 $identity = Zend_Auth::getInstance()->getIdentity();
		 
		 $info = new Louis_System_Info();
		 $info->setGroupInfo($identity);
		 
		 $group_id = $identity->group_id;
		
		 $db = Zend_Db_Table::getDefaultAdapter();
		  
		  $select = $db->select()
		  				->from('privileges as p')
		  				->join('user_group_privileges as gp', 'gp.privilege_id = p.id')
		  				->where('status = 1')
		  				->where('group_id = ?', $group_id);
		  				
		  $result = $db->fetchAll($select);
		 
		  
		  if(!empty($result))
		  {
			 $arrPrivileges = array();
			 foreach($result as $key):
	 $arrPrivileges[] = $key['module'] . '_' . $key['controller'] . '_' . $key['action'];
			 endforeach; 
			 
		$ns->acl['privileges'] = $arrPrivileges;
		//$nsInfo = $ns->getIterator();
		 
		 
			 
		/*	  $auth = Zend_Auth::getInstance();
            //luu dada vao session
            $storage = $auth->getStorage(); 
            $storage->write($authAdapter->getResultRowObject(
                array('id','username' , 'first_name' , 'last_name', 'role', 'group_id')));
                
                */
		  }
		  
		  
		  				
	}
	
	public function createRole($options = null)
	{
		$ns = new Zend_Session_Namespace('info');
		$nsInfo = $ns->getIterator();
		$info = $nsInfo['group'];
		$group_name  = $info['title'];
		$ns->acl['role'] = $group_name;
		
		
	}
}