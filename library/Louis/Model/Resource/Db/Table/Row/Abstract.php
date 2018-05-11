<?php
abstract class Louis_Model_Resource_Db_Table_Row_Abstract
   {
       protected $_row = null;
       public function __construct(array $config = array())
       public function __get($columnName)
       public function __isset($columnName)
       public function __set($columnName, $value)
       public function getRow()
       public function setRow(array $config = array())
       public function __call($method, array $arguments)
   }
