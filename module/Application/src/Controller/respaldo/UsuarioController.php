<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Model\Dao\UsuarioDao;

class UsuarioController extends AbstractActionController {

    private $usuarioDao;
    
    private $config;

    public function __construct(UsuarioDao $usuarioDao, array $config) {
        $this->usuarioDao = $usuarioDao;
        $this->config = $config;
    }

    public function indexAction() {
        return $this->forward()->dispatch(UsuarioController::class, ['action' => 'listar']);
    }

    public function listarAction() {
		
        $layout = $this->layout();
        //$layout->algunaVariable = "datos";
        $layout->setTemplate('layout/layout_otro');
        
        return new ViewModel(['listaUsuario' => $this->usuarioDao->obtenerTodos(),
                    'titulo' => $this->config['parametros']['mvc']['usuario']['titulo']]);
    }

    public function verAction() {
		
        $id = (int) $this->params()->fromRoute("id", 0);

        $usuario = $this->usuarioDao->obtenerPorId($id);

        if (null === $usuario) {
            return $this->redirect()->toRoute('usuario', ['action' => 'listar']);
        }

        return new ViewModel(['usuario' => $usuario,
                    'titulo' => "Detalle usuario"]);
    }
	public function buscarAction(){
        
        $nb = (string) $this->params()->fromPost("nombre",null);
         echo "<script>alert('".$nb."');</script>";
         
        //$resultado = $datos->buscarPorNombre($nb);
        
        return new ViewModel(['usuario' => $this->usuarioDao->buscarPorNombre($nb),
                    'titulo' => "Detalle usuario"]);
    }

}
