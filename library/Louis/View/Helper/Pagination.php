<?php
class Louis_View_Helper_Pagination extends
Zend_View_Helper_Abstract
{
	public function pagination()
	   {
			 return $this;
		}
		 
		
   function findStart($limit)
	{
		if ((!isset($_GET['page'])) || ($_GET['page'] == "1"))
		{
			$start = 0;
			$_GET['page'] = 1;
		}
		else
		{
			$start = ($_GET['page']-1) * $limit;
		}
		
		return $start;
	}
	function findPages($count, $limit)
	{
		$pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;
		return $pages;
	}

	

	function pageList($curpage, $pages)
	{
	 //  $style="style='background:#004080; border:#FFFFFF 1px solid; color:#FFFFFF; padding:10px; text-align:center'";
	   $file=$_SERVER['PHP_SELF'];
       $file=substr($file,0,strlen($file)-4);
       $mang=explode('/',$file);
       $ten_file=$mang[count($mang)-1];
      // $file='/'.$mang[1].'/'. str_replace('_','-',$ten_file);
       $file="/tin-tuc";
		$page_list="<div class='paginationControl pagination paging clearfix'>";
		$page_list.="<ul>";
			if(($curpage!=1)&&($curpage))
			{
				$page_list.="<li><a href =\"".$file."/1\" title=\"Trang đầu\"><<</a></li>";
			}
			if(($curpage-1)>0)
			{
				$page_list.="<li><a href =\"".$file."/".($curpage-1)."\" title=\"Về trang trước\"><</a></li>";
			}
		//	if($curpage>2)
		//		$page_list.="<div $style>...</div>";
				
			$vtdau=max($curpage-2,1);
			$vtcuoi=min($curpage+2,$pages);
			
				for($i=$vtdau;$i<=$vtcuoi;$i++)
				{
					if($i==$curpage)
					{
						$page_list.="<li><span class='active'><b>".$i."</b></span></li>";
					}
					else
					{
						$page_list.="<li><a href ='".$file."/".$i."' title='Trang ".$i."'>".$i."</a></li>";
					}
				}

		//	if(($curpage+2)<$pages)
		//		$page_list.="<div $style>...</div>";

			if(($curpage+1)<=$pages)
			{
				$page_list.="<li><a href =\"".$file."/".($curpage+1)."\" title=\"Đến trang sau\">></a></li>";
				$page_list.="<li><a href =\"".$file."/".$pages."\" title=\"Đến trang cuối\">>></a></li>";
			}
			$page_list.="</ul>";
			$page_list.= "</div>";
			return $page_list;
	}
    function pageList_admin($curpage, $pages)
	{
	   $style="style='background:#004080; border:#FFFFFF 1px solid; color:#FFFFFF; width:20px; padding:5px; text-align:center'";
	   $file=$_SERVER['PHP_SELF'];
       $file=substr($file,0,strlen($file)-4);
       $mang=explode('/',$file);
       $ten_file=$mang[count($mang)-1];
       $file='/'.$mang[1].'/quan-tri/'. str_replace('_','-',$ten_file);
		$page_list="";
			if(($curpage!=1)&&($curpage))
			{
				$page_list.="&nbsp;"."<span $style><a href =\"".$file."/1\" title=\"Trang đầu\"><<</a></span>";
			}
			if(($curpage-1)>0)
			{
				$page_list.="&nbsp;"."<span $style><a href =\"".$file."/".($curpage-1)."\" title=\"Về trang trước\"><</a></span>";
			}
		//	if($curpage>2)
		//		$page_list.="<div $style>...</div>";
				
			$vtdau=max($curpage-2,1);
			$vtcuoi=min($curpage+2,$pages);
			
				for($i=$vtdau;$i<=$vtcuoi;$i++)
				{
					if($i==$curpage)
					{
						$page_list.="&nbsp;"."<span $style><b>".$i."</b></span>";
					}
					else
					{
						$page_list.="&nbsp;"."<span $style><a href ='".$file."/".$i."' title='Trang ".$i."'>".$i."</a></span>";
					}
				}

		//	if(($curpage+2)<$pages)
		//		$page_list.="<div $style>...</div>";

			if(($curpage+1)<=$pages)
			{
				$page_list.="&nbsp;"."<span $style><a href =\"".$file."/".($curpage+1)."\" title=\"Đến trang sau\">></a></span>";
				$page_list.="&nbsp;"."<span $style><a href =\"".$file."/".$pages."\" title=\"Đến trang cuối\">>></a></span>";
			}
			return $page_list;
	}
	
	function nextPrev($curpage,$pages)//chỉ hiển thị 2 nút Truoc và Sau
		{
			$next_prev="";
			if(($curpage-1)<=0)
			{
				$next_prev.="Về trang trước";
			}
			else
			{
				$next_prev.="<a href =\"".$_SERVER['PHP_SELF']."/".($curpage-1)."\">Về trang trước</a></div>";
			}
			$next_prev.=" | ";
			if(($curpage+1)>$pages)
			{
				$next_prev.="Đến trang sau";
			}
			else
			{
				$next_prev.="<a href =\"".$_SERVER['PHP_SELF']."/".($curpage+1)."\">Đến trang sau</a></div>";
			}
			return $next_prev;
		}
}