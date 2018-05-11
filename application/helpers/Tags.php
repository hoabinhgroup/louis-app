<?php
class Zend_Controller_Action_Helper_Tags extends
Zend_Controller_Action_Helper_Abstract
{
	public function direct() 
		{
		$db = Zend_Db_Table::getDefaultAdapter();
		$selecttags = 'SELECT name FROM tags';
		$resultags = $db->fetchAll($selecttags);
		$arrTags= array();
		foreach($resultags as $ktag =>$vtag):
		  $arrTags[] = implode(',',$vtag);
		endforeach;
		return '["'.join('","',$arrTags).'"]';

		}

	public function active($post_tags, $pid) 
		{
			$db = Zend_Db_Table::getDefaultAdapter();
			
			$arrTags = explode(',', $post_tags);
         
           //Duyệt từng phần tử của Tags

		   foreach ($arrTags as $tag)
		   {
		   $tag = trim($tag);

		   //Lấy id của tag có tên là $tag, nếu ko có thì thêm mới
		   $getidtag = $db->fetchRow('SELECT id FROM tags WHERE name= "'.$tag.'"');
		 	  if ($getidtag)
		   {
		   	$idTag = $getidtag['id'];
			}
			else
			{
		//$flashMessenger = $this->getActionController()->getHelper('FlashMessenger');
	 // $ident = $this->_helper->string($tag,'-');
	 $ident = Zend_Controller_Action_HelperBroker::getStaticHelper('string')->direct($tag,'-');
	   $insertTag = 'INSERT INTO tags (name, ident) VALUES ("'.$tag.'","'.$ident.'")';
       $res =  $db->query($insertTag); 
       $idTag = $db->lastInsertId();
 
	   	}

  //Insert dữ liệu vào table Articles_Tags
  $product_tags = 'INSERT INTO product_tags (product_id, tag_id) VALUES ("'.$pid.'", "'.$idTag.'")';
 $db->query($product_tags); 
		}

		}
		
	public function update($post_tags, $id)
	{
			$db = Zend_Db_Table::getDefaultAdapter();
		 //tags
            
            $delete = 'DELETE FROM product_tags WHERE product_id = "'.$id.'"';
            $db->query($delete);
            
           // $this->_helper->cache($url);
           $arrTags_post =  explode(',', $post_tags);
           		   foreach ($arrTags_post as $tag)
		   {
		   $tag = trim($tag);

		
		   $getidtag = $db->fetchRow('SELECT id FROM tags where name= "'.$tag.'"');
           if ($getidtag)
           {
                $idTag = $getidtag['id'];
           }
           else
           {
        	   //$ident = $this->_helper->string($tag,'-');
        	   $ident = Zend_Controller_Action_HelperBroker::getStaticHelper('string')->direct($tag,'-');
        	   $insertTag = 'INSERT INTO tags (name, ident) VALUES ("'.$tag.'","'.$ident.'")';
               $res =  $db->query($insertTag); 
               $idTag = $db->lastInsertId();
        	  
           }

           $product_tags = 'INSERT INTO product_tags (product_id, tag_id) VALUES ("'.$id.'", "'.$idTag.'")';
        $db->query($product_tags); 
}
	}

}