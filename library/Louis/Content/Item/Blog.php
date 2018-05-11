<?php
class Louis_Content_Item_Blog extends Louis_Content_Item_Abstract
{
    public $id;
    public $name;
    public $name_clean;
    public $photo;
    public $author_id;
    public $description;
    public $content;
    public $publish;
    public $date_created;
    protected $_namespace = 'blog';
}