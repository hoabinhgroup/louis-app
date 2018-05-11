<?php
class Form_MenuItem extends Zend_Form
{
    public function init()
    {
	    $menuID = Zend_Controller_Front::getInstance()->getRequest()->getParam('menu');
	   $this->setAction('/admin/menuitem/add/menu/'.$menuID) 
	        ->setAttrib('id', 'add_menuitem');
        $this->setMethod('post');
        // create new element
        $id = $this->createElement('hidden', 'id');
        // element options
        $id->setDecorators(array('ViewHelper'));
        // add the element to the form
        //$this->addElement($id);
        // create new element
        $menuId = $this->createElement('hidden', 'menu_id');
        // element options
        $menuId->setDecorators(array('ViewHelper'));
        // add the element to the form
        //$this->addElement($menuId);
       
        $mdlMenu = new Model_MenuItem();
        $parentVal = 0;
        $a = null;
        $menuID = Zend_Controller_Front::getInstance()->getRequest()->getParam('menu');
        if($menuID == null){
	        $mID = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');

	       $a =  $mdlMenu->getMenuidByID($mID)->toArray();
	     $menuID =  $a[0]['menu_id'];
	     $parentVal = $a[0]['parent'];
        }

       $cat = $this->createElement('Select', 'parentID');
       $cat->setDecorators(
	       array(array('ViewScript', array(
                        'viewScript' => '_select-box-multi-level.phtml',
      )))
       );
      // $this->addElement($cat);
      	
        // create new element
        $label = $this->createElement('text', 'name');
        // element options
        $label->setLabel('Tiêu đề: ');
        $label->setRequired(TRUE);
        $label->addFilter('StripTags');
        $label->setAttrib('size',40);
        // add the element to the form
       // $this->addElement($label);
        // create new element
        $pageId = $this->createElement('select', 'page_id');
        // element options
        $pageId->setLabel('Trang: ');
        $pageId->setRequired(true);
        // populate this with the pages
        $mdlPage = new Model_Page();
        $pages = $mdlPage->fetchAll(null, 'name');
        $pageId->addMultiOption(0, 'None');
        if($pages->count() > 0) {
            foreach ($pages as $page) {
                $pageId->addMultiOption($page->id, $page->name);
				} 
			}
        // add the element to the form
       // $this->addElement($pageId);
        // create new element
        $link = $this->createElement('text', 'link');
        // element options
        $link->setLabel('Đường dẫn khác: ');
        $link->setRequired(false);
        $link->setAttrib('size',40);
        // add the element to the form
        //$this->addElement($link);
        
        
           $link_folder = $this->createElement('text', 'link_folder');
        // element options
        $link_folder->setLabel('Đường dẫn thư mục: ');
        $link_folder->setRequired(false);
        $link_folder->setAttrib('size',40);
        // add the element to the form
       // $this->addElement($link_folder);
       // $submit = $this->addElement('submit', 'submit', array('label' => 'Submit'));
       /*
       $checkbox = $this->addElement('checkbox', 'isHome', array(
	   	'label' => 'Hien thi o trang chu',
	   	'name' => 'isHome',
	   	'checkedValue' => 'Yes',
	   	'uncheckedValue' => 'No',
	   	));
	   	$checkbox->setChecked(true);
*/

 $description = $this->createElement('textarea', 'description');
    // element options
    $description->setLabel('Miêu tả: ');
    $description->setRequired(TRUE);
    $description->setAttrib('cols',40);
    $description->setAttrib('rows',4);
    // add the element to the form
    //$this->addElement($description);
    
    
 $is_conveyance_required = new Zend_Form_Element_Checkbox('is_conveyance_required', array('label' => 'Hiển thị','checkedValue'  => 'Yes','uncheckedValue' => 'No',));

 
    if($a[0]['isHome'] == 'Yes'){
   //$is_conveyance_required->setValue('Yes');
   $is_conveyance_required->setChecked( true );
   }
 //  $this->addElement($is_conveyance_required);
       
     
    		
       $submit = $this->addElement('submit', 
        							'submit',
        					array('label' => 'Submit',
        							'attribs' => array('class' => 'btn btn-info')
        											
        								));
        								
           $this->addElements( array (
        
                            $id,
                            $menuId,
                            $cat,
                            $label,
                            $pageId,
                            $link,
                            $link_folder,
                            $description,
                            $is_conveyance_required,                          
                           $submit
                            )
                );
    
    		 $this->addDisplayGroup(array(
        
                    'id',
                    'menu_id',
                    'name',
                    'link',
                    'link_folder',
                    'description',
        
            ),'left');
        
        $col = $this->getDisplayGroup('left');
        $col->setDecorators(array(
        
                    'FormElements',
                    'Fieldset',
                    array('HtmlTag',array('tag'=>'div','class'=>'col-md-8'))
        ));
    
    
    $this->addDisplayGroup(array(
        			'parentID',	
                    'page_id',       
                    'is_conveyance_required',
                    'submit'
        
            ),'right');
        
        $col = $this->getDisplayGroup('right');
        $col->setDecorators(array(
        
                    'FormElements',
                    'Fieldset',
                    array('HtmlTag',array('tag'=>'div','class'=>'col-md-4'))
        ));
    
						
        								
        								
    }
}
