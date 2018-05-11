<?php
class Louis_View_Helper_Feed extends Zend_View_Helper_Abstract{
        
       public function Feed()
		 {
			 return $this;
		 }
		 
		 public function rss($feedUrl, $num = 3)
		 {
			 
		 try {
        $feed = Zend_Feed_Reader::import($feedUrl);
    } catch (Zend_Feed_Exception $e) {
        echo '<p>Feed not available.</p>';
        return;
    }

  	  $posts = 0;

    foreach ($feed as $entry) {
        if (++$posts > $num) break;
        $title = $entry->getTitle();
        $link = $entry->getLink();
        $description = $entry->getDescription();
        echo "<li><a target='_blank' href=\"$link\">$title</a></li>";
		}


		 }


    } 