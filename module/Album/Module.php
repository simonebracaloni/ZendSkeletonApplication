<?php

namespace Album;

use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface 
        {

    public function onBootstrap(\Zend\Mvc\MvcEvent $e) {

        // $eventManager = $e->getApplication()->getEventManager();
        $this->app = $e->getApplication();
        $sharedManager = $this->app->getEventManager()->getSharedManager();
        
        
        $sharedManager->attach(
                '*',
                'editAlbumModel', function ($e)  {
            
//            var_dump($e);
//            die;
            
            $event = $e->getName();
            $target = get_class($e->getTarget());
            $params = json_encode($e->getParams());
            
            error_log(sprintf(
                            'SHARED: %s called on %s, using params %s', $event, $target, $params
            ));
        });
        
        
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('editAlbumModel', function ($e) {
           $event = $e->getName();
            $target = get_class($e->getTarget());
            $params = json_encode($e->getParams());

            error_log(sprintf(
                            'APP: %s called on %s, using params %s', $event, $target, $params
            ));  
        });
        //$this->serviceManager = $this->app->getServiceManager();
        //$this->serviceManager->get('Album\Model\AlbumTable')->setEventManager($eventManager);
        
    }

    public function getAutoloaderConfig() 
    {   
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() 
            {
        return include __DIR__ . '/config/module.config.php';
    }

    
    public function getServiceConfig() 
            {
         
        return array(
            'factories' => array(
                 'Album\Model\AlbumTable' =>  function($sm) {
                    $tableGateway = $sm->get('AlbumTableGateway');
                    $table = new AlbumTable($tableGateway);
                    return $table;
                },
                'AlbumTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

}
