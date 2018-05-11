<?php
class Louis_View_Helper_Image extends
Zend_View_Helper_Abstract
{
	public function image()
	   {
			 return $this;
		}
		 
		 	
	public function getDefaultImageProduct($productID)
	{
		$model = new Product_Model_ProductImage();
		
		$select = $model->select()
						->where('productId = ?', $productID)
						->where('isDefault = ?', 'Yes');
				
		    $result = $model->fetchAll($select);		
						
			$arrImage = $result->toArray();

	    if(isset($arrImage[0]['full'])){
		return '/public/images/product/'.$productID.'/'.$arrImage[0]['full'];
		}
		else {
		return 'http://demopavothemes.com/pav_styleshop/d/image/cache/data/demo/product_09-202x224.jpg';
		}
	}
	
	public function getFirstImageContent($content){
		    $first_img = array();
			$dom = new Zend_Dom_Query($content);

			$imgs = $dom->query('img');
			foreach ($imgs as $img) {

			$first_img[] = $img->getAttribute('src');
			}
			
			if($first_img != null)
			{
				return $first_img[0];
			}
			
			
	}
	
	public function get_youtube_thumb($link, $type = 'hqdefault'){
//default.hqdefault.mqdefault.sddefault.maxresdefault
    $video_id = explode("?v=", $link); 
        if (empty($video_id[1])){
           $video_id = explode("/v/", $link); 
           $video_id = explode("&", $video_id[1]); 
           $video_id = $video_id[0];
        }
    $thumb_link = "";
    if($type == 'default' || $type == 'hqdefault' || $type == 'mqdefault' || $type == 'sddefault' || $type == 'maxresdefault'){

        $thumb_link = 'http://img.youtube.com/vi/'.$video_id[1].'/'.$type.'.jpg';

    }elseif($type == "id"){
        $thumb_link = $video_id;
    }
    return $thumb_link;}
}