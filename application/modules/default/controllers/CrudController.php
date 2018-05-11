<?php 
class CrudController extends Louis_Controller_Action{ 
	

	public function init(){
		parent::init();	
      }
      
    public function indexAction(){ 
		
		 
    }
    
    public function listAction()
    {
	    $this->_helper->viewRenderer->setNoRender(true);
	    $this->_helper->layout->disableLayout();
	    // $data = $this->_request->getParams();
	    
	     $page = $this->_request->getParam('page', 1);
	     $search_input = $this->_request->getParam('search_input', 0);
	   //  $per_page = ($page - 1) * 20;
	   
	     
	     $customer = new Model_Customer();
	     
	       $options = array();  
	    	     
	     if($search_input != ''){
		      $options['search_input'] = $search_input;
	     }
	     
	     $result_total = count($customer->get_details($options));
	     
	      $options['page'] = $page;
	     $result = $customer->get_details($options);
	    
	   
	      $data['student_data'] = $result;
	      $data['total'] = $result_total;
	    $this->_helper->json($data);
    }
    
    	function selectAction()
    	{
	    	$this->_helper->viewRenderer->setNoRender(true);
			$this->_helper->layout->disableLayout();
			
			$customer_id = $this->_request->getParam('student_id', 0);
			
			if($customer_id != '0'){
			 $customer = new Model_Customer();
			 $data = $customer->get_one($customer_id);			
			 }
			 
			 $this->_helper->json($data->toArray());
    	}
    
		function updateAction()
		{
			$this->_helper->viewRenderer->setNoRender(true);
			$this->_helper->layout->disableLayout();
			
			$data = json_decode(file_get_contents("php://input"));
			$customer = new Model_Customer();
			$result = $customer->update_where(array(
				'name' => $data->name,
				'code' => $data->code,
				'job'  => $data->job,
				'work'  => $data->work,
			), array('id' => $data->id));
			if($result){
				$message['message']='Cập nhật thành công!';
			}else{
				$message['message']='Có lỗi trong quá trình cập nhật dữ liệu!';
			}
			
			 $this->_helper->json($message);
		}
		
		function insertAction()
		{
			$this->_helper->viewRenderer->setNoRender(true);
			$this->_helper->layout->disableLayout();
			
			$data = json_decode(file_get_contents("php://input"));
			$customer = new Model_Customer();
			$result = $customer->save(array(
				'name' => $data->name,
				'code' => $data->code,
				'job'  => $data->job,
				'work'  => $data->work,
			));
			if($result){
				$message['message']='Thêm thành công!';
			}else{
				$message['message']='Có lỗi trong quá trình thêm mới dữ liệu!';
			}
			
			 $this->_helper->json($message);
		}
		
		
		function detailAction()
		{
			$this->_helper->viewRenderer->setNoRender(true);
			$this->_helper->layout->disableLayout();
			
			$customer_id = $this->_request->getParam('student_id', 0);
			
			if($customer_id != '0'){
			 $customer = new Model_Customer();
			 $data = $customer->get_one($customer_id);			
			 }
			 
			 $this->_helper->json($data->toArray());
		}
		
		function deleteAction()
		{
			$this->_helper->viewRenderer->setNoRender(true);
			$this->_helper->layout->disableLayout();
			
			$data = json_decode(file_get_contents("php://input"));
			// $this->_helper->json($data);
			 $customer = new Model_Customer();
			$result = $customer->delete_where(array('id' => $data));
			
			if($result){
				$message['message']='Xóa thành công!';
			}else{
				$message['message']='Có lỗi trong quá trình xóa dữ liệu!';
			}
			
			 $this->_helper->json($message);
		}
		
		function testAction()
		{
			$this->_helper->viewRenderer->setNoRender(true);
			$this->_helper->layout->disableLayout();
			
			$a = array(
    array(
    'title' =>  'Giải kỷ lục',
    'img' => 'honda-cong-bo-gia-lead-125-2017-tai-thi-truong-viet-nam-40077-1500919596-5976372cea3a6.png'
	),
	 array(
    'title' =>  'Giải đặc biệt',
    'img' => 'Line-up-White-800x525.png'
	),
	 array(
    'title' =>  'Giải nhất',
    'img' => '11708_smart_tivi_skyworth_40_inch_40s810_full_hd_22k4s9.png'
	),
	 array(
    'title' =>  'Giải nhì',
    'img'  => 'AQD-D980ZT_L.png'
	),
	 array(
    'title' =>  'Giải ba',
    'img' => 'samsung-galaxy-note-edge.png'
	),
	 array(
    'title' =>  'Giải tư',
    'img' => 'quat-phun-suong-tao-am-kg559-chinh-hang.jpg'
	),
	 array(
    'title' =>  'Giải khuyến khích',
    'img' => 'havico.jpeg'
	),
);

	$this->_helper->json($a);
		}
      
}