<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{
	
	protected function _initSession(){
		Zend_Session::start();
	}
	
	
	protected function _initLocale()
	{
	//	$locale = Zend_Locale('vi_VN');
		//Zend_Registry::set('Zend_Locale', $locale);
	}
	
	 protected function _initZFDebug() {
        $identity = Zend_Auth::getInstance()->getIdentity();
        
        if (isset($identity) && ($identity->id == 3)) {
            $dbResource = $this->getPluginResource('db');
            $dbAdapter = $dbResource->getDbAdapter();

            $cacheResource = $this->getPluginResource('cachemanager');
            $cacheManager = $cacheResource->getCacheManager();
            $cache = $cacheManager->getCache('default');
            $cacheBackend = $cache->getBackend();

            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace('ZFDebug');

            $options = array(
                'plugins' => array(
                    'Variables',
                    'Database' => array('adapter' => $dbAdapter),
                    'File' => array('basePath' => APPLICATION_PATH),
                    'Cache' => array('backend' => $cacheBackend),
                    'Exception'
                )
            );
            $debug = new ZFDebug_Controller_Plugin_Debug($options);

            $this->bootstrap('frontController');
            $frontController = $this->getResource('frontController');
            $frontController->registerPlugin($debug);
        }
    }
	
	protected function _initSearch(){
	Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');
Zend_Search_Lucene_Analysis_Analyzer::setDefault(
    new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive ()
);
		}
		
	 protected function _initCachemanager(){
        $cacheManager=new Zend_Cache_Manager;
        $dbcache=array(
            'frontend'=>array(
                'name'=>'Core',
                'options'=>array(
                    'lifetime'=>null,
                    'automatic_serialization'=>'true',
                ),
            ),
            'backend'=>array(
                'name'=>'File',
                'options'=>array(
                    'cache_dir'=>CACHE_DIR,
                ),
            ),
        );
        $cacheManager->setCacheTemplate('dbcache',$dbcache);
        return $cacheManager;
    }
	
	 protected function _initRoutes()
    {
	    
    	$front_controller = Zend_Controller_Front::getInstance();
    	
    	 
        
        $router = $front_controller->getRouter();

         $route = new Zend_Controller_Router_Route(
            'customer',
            array(
                'action'        => 'customer',
                'controller'    => 'index',
                'module'        => 'default',
            )
        );

        $router->addRoute('customer', $route);
        
        
	}
	
	
	public function _initAutoload(){
		Zend_Controller_Action_HelperBroker::addPath(
APPLICATION_PATH .'/helpers');
	
        $front = Zend_Controller_Front::getInstance();
      //  $front->registerPlugin(new Louis_Plugin_Permission());
        $front->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(array(
                                'module'     => 'error',
                                'controller' => 'error',
                                'action'     => 'error'
        )));
       
        
    }
    
 
  protected function _initLayout(){
   // $layout = explode('/', $_SERVER['REQUEST_URI']);

      $options = array(
             'layout'     => 'layout',
             'layoutPath' => PUBLIC_PATH
      );
    Zend_Layout::startMvc($options);
	}
	
	

	public function setConstants($constants)
	{
    // define() is notoriously slow
    if (function_exists('apc_define_constants')) {
        apc_define_constants('zf', $constants);
        return;
    }

    foreach ($constants as $name => $value) {
        if (false === defined($name)) {
            define($name, $value);
        }
    }
	}
	
	protected function _initDatabase(){
        $db = $this->getPluginResource('db')->getDbAdapter();
        Zend_Db_Table::setDefaultAdapter($db); //important
        Zend_Registry::set('db', $db);    
	}
	
	/*
	protected function _initFrontcontroller()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->setControllerDirectory(APPLICATION_PATH . "modules/default/controllers");
		return $front;
	}
	*/
	
	/*  protected function _initMenus()
	 {
    $view = $this->getResource('view');
    $view->mainMenuId = 2;
    $view->adminMenuId = 3;
	}

	*/
	
  
}