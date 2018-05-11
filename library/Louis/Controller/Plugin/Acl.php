<?php
class Louis_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		// set up acl
		$acl = new Zend_Acl();
		
		$acl->addRole(new Zend_Acl_Role('guest'));
		
		$acl->addRole(new Zend_Acl_Role('user'), 'guest');
		
		$acl->addRole(new Zend_Acl_Role('administrator'), 'user');
		
		// add the resources
        $acl->add(new Zend_Acl_Resource('admin-index'));
        $acl->add(new Zend_Acl_Resource('error'));
        $acl->add(new Zend_Acl_Resource('admin-page'));   
        $acl->add(new Zend_Acl_Resource('admin-menu'));
        $acl->add(new Zend_Acl_Resource('admin-menuitem'));
        $acl->add(new Zend_Acl_Resource('admin-user'));
        $acl->add(new Zend_Acl_Resource('admin-new'));
        
    
	  
		$acl->allow('guest', 'admin-user', array('login'));
	
	// $acl->deny('guest', 'product:admin-product', array('list', 'create', 'edit', 'delete'));
		
		// user
		$acl->allow('user', 'admin-index');
		$acl->allow('user', 'admin-page', array('list', 'create', 'edit', 'delete'));
		$acl->allow('user', 'admin-user', array('logout'));
		$acl->allow('user', 'admin-new');
		$acl->allow('user', 'admin-menu');
		$acl->allow('user', 'admin-menuitem');
		
		$acl->deny('user', 'admin-menu', array('edit'));
		
		// administrators can do anything
		$acl->allow('administrator', null);

		
		// fetch the current user
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			$role = strtolower($identity->role);
			}else{
				$role = 'guest';
		}
		
		
		$controller = $request->controller;
	
		$action = $request->action;
	
		$module = $this->_request->getModuleName();
		
		
		//echo $resource = $module.':'.$controller;
			   
		//echo $role;
		
		try {
		if (!$acl->isAllowed($role, $controller, $action)) {
			if ($role == 'guest') {
		$request->setModuleName('user');
        $request->setControllerName('admin-user');
        $request->setActionName('login');
		}
			  
	   else {
		//$request->setModuleName('error');	
       $request->setControllerName('error');
      // $request->setActionName('error');
      echo 'Bạn không đủ quyền truy cập!';
	   }
	   	}	
	   	
	   	/*
	   
	   */
	   	   //  Zend_Loader::loadClass('nonexistantclass');
				    } catch (Zend_Exception $e) {
					   // echo 23232;
				       // echo "Caught exception: " . get_class($e) . "\n";
				       //echo "Message: " . $e->getMessage() . "\n";
				   //header("Location: /admin/user/login");
				    }
	     
		
	}
}