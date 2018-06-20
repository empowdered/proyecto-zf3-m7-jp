<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\Config\Reader\Ini;
/*
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Usuario\Model\Dao\IUsuarioDao;
use Usuario\Model\Dao\UsuarioDao;
use Usuario\Model\Entity\Usuario;
*/
class Module  {

    const VERSION = '3.0.2dev';

    function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    function onBootstrap($e) 
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'initConfig']);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'initViewRender']);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'initEnvironment']);
    }
    function initViewRender(MvcEvent $e) {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $viewRender = $sm->get('ViewRenderer');
        $config = $sm->get('ConfigIni');

        $viewRender->headTitle($config['parametros']['titulo']);
        $viewRender->headMeta()->setCharset($config['parametros']['view']['charset']);
        $viewRender->doctype($config['parametros']['view']['doctype']);
    }

    function initEnvironment(MvcEvent $e) {
		
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $config = $sm->get('ConfigIni');
        error_reporting(E_ALL | E_STRICT);
        ini_set("display_errors", true);

        $timeZone = (string) $config['parametros']['timezone'];

        if (empty($timeZone)) {
            $timeZone = "America/Santiago";
        }

        date_default_timezone_set($timeZone);
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
    /*
    function getServiceConfig() {
        return [
            'factories' => [
                'UsuarioTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                    return new TableGateway('usuario', $dbAdapter, null, $resultSetPrototype);
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
                
            ],
        ];
    }
     * */
     
}
