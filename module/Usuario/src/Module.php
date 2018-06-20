<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuario;

use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

//esta es la linea de zend-authenticator
use Zend\Authentication\AuthenticationService;
use Usuario\Model\Dao\IUsuarioDao;
use Usuario\Model\Dao\UsuarioDao;
use Usuario\Model\Entity\Usuario;

class Module {

    function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    function onBootstrap($e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'onStart'], 100);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'onEnd'], -100);
    }
    function initAuth(MvcEvent $e){
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $auth = $serviceManager->get(Login::class);
        
        //pasamos el objeto auth al layout
        $layout = $e->getViewModel();
        $layout->auth = $auth;
        
        $matches = $e->getRouteMatch();
        $controllerName = $matches->getParam('controller');
        
    }
    function onStart($e) {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $inicio = round(microtime(true) * 1000);
        $sm->setService('time_start', $inicio);
    }

    function onEnd($e) {

        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $time_start = $sm->get('time_start');
        $time_end = round(microtime(true) * 1000);
        $resultado = round($time_end - $time_start);
        //$resultado = $time_start;
        $e->getViewModel()->setVariable('tiempoInicial', "El tiempo de arranque es de {$time_start} milisegundos");
        $e->getViewModel()->setVariable('tiempoFinal', "El tiempo final de parada es de {$time_end} milisegundos");
        $e->getViewModel()->setVariable('tiempoCarga', "El tiempo de carga total es de {$resultado} milisegundos");
    }
    	
	//esta funcion no existe en la version solucion4
    function initConfig(MvcEvent $e)
    {
        $application = $e->getApplication();
        $services    = $application->getServiceManager();	
        $services->setFactory('ConfigIni', function ($services) {
            $reader = new Ini();
            $data = $reader->fromFile(__DIR__ . '/../config/config.ini');
            return $data;
        });
    }
    function getServiceConfig() {
        return [
            'factories' => [
                'UsuarioTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                    return new TableGateway('usuario', $dbAdapter, null, $resultSetPrototype);
                },
                AuthenticationService::class => InvokableFactory::class,
                  Login::class => function($sm){
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $authService = $sm->get(AuthenticationService::class);
                    return new Login($dbAdapter, $authService);
                  },
                IUsuarioDao::class => function($sm) {
                    $tableGateway = $sm->get('UsuarioTableGateway');
                    $this->dao = new UsuarioDao($tableGateway);
                    return $this->dao;
                },
                'ConfigIni' => function($sm) {
                    $reader = new Ini();
                    $data = $reader->fromFile(__DIR__ . '/../config/config.ini');
                    return $data;
                },
                'aliases' => [
                    'auth_service' => AuthenticationService::class,
                ]
                
            ],
        ];
    }
}
