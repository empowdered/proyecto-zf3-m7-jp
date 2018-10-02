<?php

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuario\Form\Login as LoginForm;
use Usuario\Model\Login as LoginService;
use Usuario\Form\LoginValidator;
use Zend\View\Exception\RuntimeException;

class LoginController extends AbstractActionController{
    
    private $login;
    
    function __construct(LoginService $login) {
        $this->login = $login;
    }
    function indexAction(){
        return [
            'titulo' => 'Login',
            'form' => new LoginForm("login"),
            'identity' => $this->login->getIdentity(),
        ];
    }
    function autenticarAction(){
        
        if(!$this->request->isPost()){
           $this->redirect()->toRoute('login', ['action' => 'index']);
        }
        
        $form = new LoginForm("login");
        $form->setInputFilter(new LoginValidator());
        
        //obtenemos los datos desde  el formulario con POST
        $data = $this->request->getPost();
        $form->setData($data);
        
        //validamos el form
        if(!$form->isValid()){
            $modelView = new ViewModel(['titulo' => 'Login','form'=>$form]);
            $modelView->setTemplate('usuario/login/index');
            return $modelView;
        }
        
        $values = $form->getData();
        
        try 
        {
            
            $this->login->setMessage('El nombre de Usuario y Password no coinciden.', LoginService::NOT_IDENTITY);
            $this->login->setMessage('La contraseña ingresada es incorrecta. Inténtelo de nuevo.', LoginService::INVALID_CREDENTIAL);
            $this->login->setMessage('Los campos de Usuario y Password no pueden dejarse en blanco.', LoginService::INVALID_LOGIN);
            $this->login->login($values['email'], $values['password']);

            $this->flashMessenger()->addSuccessMessage('Has iniciado sesión con éxito.');
            return $this->redirect()->toRoute('login', ['action' => 'success']);
            
        } catch (RuntimeException $e) {
            $this->flashMessenger()->addErrorMessage('Login con error');
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('login', ['action' => 'index']);
        }
    }
    function successAction() {
        return ['titulo' => 'Página de exito'];
    }
    function logoutAction() {
        $this->login->logout();
        $this->flashMessenger()->addSuccessMessage('Has cerrado sesión con éxito.');
        return $this->redirect()->toRoute('login', ['action' => 'index']);
    }
}
