<?php
//Duong dan den thu muc chua ung dung
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', 
			  realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV',
              (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
                                         : 'developer'));   // hoặc production (chế độ cho người dùng)

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

//thu muc template

define('PATH_NEWS', '/public/images/news/');

define('PATH_TOURS', '/public/images/products/');

define('PATH_HOTELS', '/public/images/hotels/');

define('PATH_PROFILES', '/public/images/profiles/');


define('CACHE_DIR', APPLICATION_PATH.'/cache/'); 
                                         
//Duong dan den thu muc /public
define('PUBLIC_PATH', realpath(dirname(__FILE__) . '/public'));

define('CONFIG_PATH', realpath(APPLICATION_PATH . '/configs'));