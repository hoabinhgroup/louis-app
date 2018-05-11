<?php 
class IndexController extends Zend_Rest_Controller{ 
	

	public function init(){
		parent::init();	
		
      }

      
    public function indexAction(){ 
			
    }
    
     // Handle GET and return a specific resource item
    public function getAction() {}

    // Handle POST requests to create a new resource item
    public function postAction() {}

    // Handle PUT requests to update a specific resource item
    public function putAction() {}

    // Handle DELETE requests to delete a specific item
    public function deleteAction() {
	    $data = json_decode(file_get_contents("php://input"));
	    $this->_helper->json($_GET);
		 $user_id = $data->userID;
		//$this->_helper->json($user_id);
		 
		 $model_lucky = new Model_Lucky();
		 $model_lucky->delete_where(array('user_id' => $user_id));
		 
		$this->_helper->json(1);
	    
    }  
    
    public function listAction()
    {
	   
	     
	     $adward = $this->_request->getParam('adward');
	     
	    $model_lucky = new Model_Lucky();
	    
	    $count = $model_lucky->getCountLuckyAdward($adward);
	     
	    $user = $model_lucky->getUser();
	    
	    if((($adward == '0') && ($count < 1))  ||
		   (($adward == '1') && ($count < 6))  ||
		   (($adward == '2') && ($count < 2))  ||
		   (($adward == '3') && ($count < 3))  ||
		   (($adward == '4') && ($count < 4))  ||
		   (($adward == '5') && ($count < 15)) ||
		   (($adward == '6') && ($count < 65)))
		{
			$limit = true;
		}else
		{
			$limit = false;
		}
	    
	    $this->_helper->json(array('data' => $user, 'count' => $count, 'limit' => $limit));
    }
    
      public function saveAction(){ 
		  $this->_helper->viewRenderer->setNoRender(true);
		  $this->_helper->layout->disableLayout();
		
		//$user_id = $this->_request->getParam('user_id');
		$data = json_decode(file_get_contents("php://input"));
		$user_id = $data->user_id;
		//$counter = $data->stt;
		$code = $data->code;
		$adward = $data->adward;
		
		$model_lucky = new Model_Lucky();
		$user_model = new User_Model_User();
		$success = $model_lucky->save(array(
			//'stt' => $counter,
			'user_id' => $user_id,
			'code' => $code,
			'adward' => $adward,
			'date_created' => time(),
		));
		if($success){
			$row = $model_lucky->get_one($success);
			$row_user = $user_model->get_one($user_id);
			$this->_helper->json(array('status' => true, 'data' => $row->toArray(), 'obj' => $row_user->toArray()));
		}else{
			$this->_helper->json(array('status' => false, 'statusText' => 'Có lỗi, xin kiểm tra lại mạng!'));
		}
		      
	
    }
    
    
    function showluckyAction()
    {	  	    	        
	  
	     $adward = $this->_request->getParam('adward');
	     //adward = 3
	     $model_lucky = new Model_Lucky();
	     $data = $model_lucky->get_details(array(
		     'adward' => $adward
	     ));
	     
	     $this->_helper->json($data);
	     
	        
    }
    
	function delAction()
	{

		 $data = json_decode(file_get_contents("php://input"));
		 $user_id = $data->userID;
		//$this->_helper->json($user_id);
		 
		 $model_lucky = new Model_Lucky();
		 $model_lucky->delete_where(array('user_id' => $user_id));
		 
		$this->_helper->json(1);
	}
	
	function emptyAction()
	{
		 $this->_helper->viewRenderer->setNoRender(true);
		 $this->_helper->layout->disableLayout();
		 $model_lucky = new Model_Lucky();
		 $model_lucky->truncate();
		 
		// $this->_redirect('/');
		 
	}
	
	function customerAction()
	{
		 //$this->_helper->layout->disableLayout();
	}
	
      
}