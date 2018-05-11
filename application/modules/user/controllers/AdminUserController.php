<?php
class User_AdminUserController extends Louis_Controller_Action
{
    public function init()
    {
    
    }
    
    
    public function showinfouserAction()
	{
	
		try {  
		         
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()) {
        $this->view->identity = $auth->getIdentity();
		}
	    
	       } catch (Zend_Exception $e) {
    echo "Caught exception: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
   
}
	}

	public function loginAction()
	{
	    // set layout cho trang login
		 $option=array(
        "layout" => "login",
        "layoutPath" => TEMPLATE_PATH ."/admin/layouts"
          ); 
        Zend_Layout::startMvc($option);
   
    $userForm = new User_Form_User();
    $userForm->setAction('/admin/user/login');
    $userForm->removeElement('first_name');
    $userForm->removeElement('last_name');
    $userForm->removeElement('role');
        try {
           
         
	if ($this->getRequest()->isPost() && $userForm->isValid($_POST)) {
        $data = $userForm->getValues();
    
        $db = Zend_Db_Table::getDefaultAdapter();
      
        $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users',
            'username', 'password');
       
        $authAdapter->setIdentity($data['username']);
        $authAdapter->setCredential(md5($data['password']));
      
        $result = $authAdapter->authenticate();
        if ($result->isValid()) {
           
            $auth = Zend_Auth::getInstance();
            //luu dada vao session
            $storage = $auth->getStorage(); 
            $storage->write($authAdapter->getResultRowObject(
                array('id','username' , 'first_name' , 'last_name', 'role', 'group_id')));
            
             $info = new Louis_System_Info();
			 $info->createInfo();
			 
            return $this->_redirect('/admin');     
              
            
             } else {
            $this->view->loginMessage = "Xin lỗi, username hoặc mật khẩu không chính xác!";
				}	
				
				
				 }
				 
		  // Zend_Loader::loadClass('nonexistantclass');
        } catch (Zend_Exception $e) {
            echo "Caught exception: " . get_class($e) . "\n";
            echo "Message: " . $e->getMessage() . "\n";
          
        }	
        
        	 
    $this->view->form = $userForm;
}


	public function logoutAction()
	{
    $authAdapter = Zend_Auth::getInstance();
    $authAdapter->clearIdentity();
     $info = new Louis_System_Info();
	 $info->destroyInfo();
     $this->_helper->redirector('login', 'user', 'admin');
	}


    
   public function createAction()
   	{     
   	      
    $userForm = new User_Form_User();
    if ($this->getRequest()->isPost()) {
    
        if ($userForm->isValid($_POST)) {
        
            $userModel = new User_Model_User();
            $userModel->createUser(
                $userForm->getValue('username'),
                $userForm->getValue('password'),
                $userForm->getValue('first_name'),
                $userForm->getValue('last_name'),
                $userForm->getValue('role')
            );
           
           return $this->_forward('list');  
              
              }
             
             // echo 21;
    }
    	
    	 //	  Zend_Loader::loadClass('nonexistantclass');
      
   	      
    $userForm->setAction('/admin/user/create');
    $this->view->form = $userForm;
    	   
	}
	
	public function listAction ()
	{
    $currentUsers = User_Model_User::getUsers();
    if ($currentUsers->count() > 0) {
        $this->view->users = $currentUsers;
    } else {
        $this->view->users = null;
      }
	 }
	 
	 
	 public function updateAction ()
	 {
	 $userForm = new User_Form_User();
	 $userForm->setAction('/admin/user/update');
	 $userForm->removeElement('password');
	 $userModel = new User_Model_User();
	 if ($this->getRequest()->isPost()){
		 if($userForm->isValid($_POST)){
			 $userModel->updateUser(
                $userForm->getValue('id'),
                $userForm->getValue('username'),
                $userForm->getValue('first_name'),
                $userForm->getValue('last_name'),
                $userForm->getValue('role')
                
				);
				
				return $this->_forward('list'); 
					}
			}else{
				$id = $this->_request->getParam('id');
				$currentUser = $userModel->find($id)->current();
				$userForm->populate($currentUser->toArray());
				
			}
			
	$this->view->form = $userForm;
	 }
	 
	 	public function passwordAction()
		{
    $passwordForm = new User_Form_User();
    $passwordForm->setAction('/admin/user/password');
    $passwordForm->removeElement('first_name');
    $passwordForm->removeElement('last_name');
    $passwordForm->removeElement('username');
    $passwordForm->removeElement('role');
    $userModel = new User_Model_User();
    if ($this->_request->isPost()) {
        if ($passwordForm->isValid($_POST)) {
            $userModel->updatePassword(
                $passwordForm->getValue('id'),
                $passwordForm->getValue('password')
				);
            return $this->_forward('list');
        }
    } else {
        $id = $this->_request->getParam('id');	 
		$currentUser = $userModel->find($id)->current();
        $passwordForm->populate($currentUser->toArray());
		}
    $this->view->form = $passwordForm;
		}
		
		
		public function deleteAction()
		{	
		$id = $this->_request->getParam('id');
		$userModel = new User_Model_User();
		$userModel->deleteUser($id);
		return $this->_forward('list');
		}
   
 }