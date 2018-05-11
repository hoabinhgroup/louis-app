<?php
class Louis_Controller_Action extends Zend_Controller_Action{
	
	protected $_lang;
	protected $_db;
/*
	public function preDispatch() {
		  $moduleName = $this->_request->getModuleName();
		  $controllerName  = $this->_request->getControllerName();
		  $actionName = $this->_request->getActionName();
       if($moduleName=='admin'){
          $auth = Zend_Auth::getInstance();
          if (!$auth->hasIdentity()) {

     if(($actionName != 'login') && ($actionName != 'render') && ($actionName != 'showinfouser'))
     		{
              $this->_helper->redirector('login', 'user', 'admin');
             }
              
         
          }
       }	
   }
   //co the chen template mo rong
   
   */
   public function init(){
	   $db = Zend_Db_Table::getDefaultAdapter();
	   $this->_db = $db;
	   $ns = new Zend_Session_Namespace('language');
	   $this->_lang = $ns->lang;
	   if (empty($ns->lang)){
			 $this->_lang = 'vi';
			 }
			 
	$param_redirect =  $this->_request->getParam('redirect');
	if($param_redirect != null){
		echo $this->_redirect($param_redirect);
	}
   }
   
   public function preDispatch() {
	  $uri = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
	   Zend_Registry::set('uri', $uri);
	   
	
	   }

}