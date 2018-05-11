<?php
class Form_TestimonialEdit extends Zend_Form
{
    public function init()
    {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAction('/admin/testimonial/edit');
       
        $id = $this->createElement('hidden', 'id');
      
        $id->setDecorators(array('ViewHelper'));
       
        $this->addElement($id);
     
        $name = $this->createElement('text', 'name');
       
        $name->setLabel('Tiêu đề: ');
        $name->setRequired(TRUE);
        $name->setAttrib('size',40);
        
        $this->addElement($name);
       
        
        
        // create new element
       /* $headline = $this->createElement('text', 'headline');
        // element options
        $headline->setLabel('Headline: ');
        $headline->setRequired(TRUE);
        $headline->setAttrib('size',50);
    // add the element to the form
    $this->addElement($headline);  */
    // create new element
  
             
            
     // create new element
    $description = $this->createElement('textarea', 'shortDescription');
    // element options
    $description->setLabel('Description: ');
    $description->setRequired(TRUE);
    $description->setAttrib('cols',40);
    $description->setAttrib('rows',4);
    // add the element to the form
    $this->addElement($description);
    // create new element
    $content = $this->createElement('textarea', 'description');
    // element options
    $content->setLabel('Content');
    $content->setRequired(TRUE);
    $content->setAttrib('cols',50);
    $content->setAttrib('rows',12);
    // add the element to the form
    $this->addElement($content);
    
     $this->addElement('text', 'date', array(
	       'required' =>true,
         'decorators' => array(array('ViewScript', array(
                        'viewScript' => '_select-box-date.phtml'
      )))
      ));
   // $submit = $this->addElement('submit', 'submit', array('label' => 'Submit'));
    $submit = $this->addElement('submit', 
        							'submit',
        					array('label' => 'Submit',
        							'attribs' => array('class' => 'btn btn-info')
        											
        								));
}
}