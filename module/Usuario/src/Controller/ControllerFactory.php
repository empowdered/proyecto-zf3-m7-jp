<?php

namespace Usuario\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
//use Usuario\Model\Dao\UsuarioDao;
use Usuario\Model\Dao\IUsuarioDao;
use Usuario\Controller\UsuarioController;
use Usuario\Model\Login;

class ControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
		
        $controller = null;
        switch ($requestedName) {
            case UsuarioController::class :
                    //$usuarioDao = $container->get(UsuarioDao::class );
                    $iusuarioDao = $container->get(IUsuarioDao::class);
                    $configIni = $container->get('ConfigIni');
                    $controller = new UsuarioController($iusuarioDao, $configIni);
                break;
            
            case LoginController::class :
                $login = $container->get(Login::class);
                $controller = new LoginController($login);
                break;
            
            default:
                return (null === $options) ? new $requestedName : new $requestedName($options);
        }
		
        return $controller;
		
    }

}
