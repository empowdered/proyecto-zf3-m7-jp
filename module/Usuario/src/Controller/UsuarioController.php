<?php

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuario\Model\Dao\IUsuarioDao;
use Usuario\Model\Entity\Usuario;
use Usuario\Form\FormularioUsuario;
use Usuario\Form\FormularioUsuarioValidator;


class UsuarioController extends AbstractActionController {

    private $iusuarioDao;
    
    private $config;

    public function __construct(IUsuarioDao $iusuarioDao, array $config) {
        $this->iusuarioDao = $iusuarioDao;
        $this->config = $config;
    }

    public function indexAction() {
       return $this->forward()->dispatch(UsuarioController::class, ['action' => 'listar']);
    }

    public function listarAction() {
	
        $layout = $this->layout();
        //$layout->algunaVariable = "datos";
        $layout->setTemplate('layout/layout_otro');
        
        $paginator = $this->iusuarioDao->obtenerTodos();
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator->setItemCountPerPage(5);
        
        /*return new ViewModel(['listaUsuario' => $this->iusuarioDao->obtenerTodos(),
                    'titulo' => $this->config['parametros']['mvc']['usuario']['titulo']]);
         * */
      return [
            'titulo' => $this->config['parametros']['mvc']['usuario']['titulo'],
            'listaUsuario' => $paginator->getIterator(),
            'paginator' => $paginator,
            ];
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
    public function buscarAction() {
        $nb = (string) $this->params()->fromPost("nombre", null);
        return new ViewModel(['usuario' => $this->usuarioDao->buscarPorNombre($nb),
            'titulo' => "Detalle usuario"]);
        //$view->setTemplate('usuario/usuario/listar');
        //return $view;
    }
    function crearAction()
    {
      try
        {
             //return $this->forward()->dispatch(UsuarioController::class, ['action' => 'listar']);
             //$nb = (string) $this->params()->fromPost("nombre", null);
             //return new ViewModel(['usuario' => $this->usuarioDao->buscarPorNombre($nb),
            //'titulo' => "Detalle usuario"]);  
            $form = new FormularioUsuario("insert");
            return ['form' => $form, 'titulo' => 'formulario crear usuario'];
        }
        catch (Exception $ex) {
            $ex->getCause();
        }
    }

    function eliminarAction(){
        //return new ViewModel([]);
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('catalogo');
        }
        $usuario = new Usuario();
        $usuario->setId($id);
        $this->iusuarioDao->eliminar($usuario);
        //return $this->redirect()->toRoute('usuario/listar');
        return $this->forward()->dispatch(UsuarioController::class, ['action' => 'listar']);
    }
    function editarAction(){
      $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('usuario');
        }

        $form = $this->getForm("insert");

        
        $usuario= $this->iusuarioDao->obtenerPorId($id);
        $form->bind($usuario);
        $form->get('send')->setAttribute('value', 'Editar');
        $modelView = new ViewModel(['titulo' => 'Editar Usuario', 'form' => $form]);
        $modelView->setTemplate('usuario/usuario/crear');
        return $modelView;
    }
    function guardarAction(){
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('usuario');
        }
        $form = $this->getForm();
        $form->setInputFilter(new FormularioUsuarioValidator());
        // Obtenemos los datos desde el Formulario con POST data:
        $data = $this->request->getPost();
        //var_dump($data);
        //exit();
        $form->setData($data);
        // Validando el form
        if (!$form->isValid()) {
            $modelView = new ViewModel(['titulo' => 'Validando Usuario', 'form' => $form]);
            $modelView->setTemplate('usuario/usuario/crear');
            return $modelView;
        }
        //nueva linea
        //$dataForm = $form->getData();
        //$dataForm['categoria_id'] = $dataForm['categoria'];
        //fin nueva linea
        
        $usuario = new Usuario();
        $usuario->exchangeArray2($data);        
        $this->iusuarioDao->guardar($usuario);
        
        return $this->redirect()->toRoute('usuario');
        
    }
    private function getForm() 
    {
        $form = new FormularioUsuario("insert");
        //$form->get('categoria')->setValueOptions($this->produtoDao->obtenerCategoriasSelect());
        return $form;
    }   
}
