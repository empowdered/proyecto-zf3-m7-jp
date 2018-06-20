<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuarios\Form\Login as LoginForm;
use Usuarios\Form\LoginValidator;
use Usuarios\Model\Login as LoginService;
use Zend\View\Exception\RuntimeException;


/**
 * Description of LoginController
 *
 * @author jpmunoz
 */
class LoginController {
    //put your code here
    private $login;
    
    function __construct(LoginService $login){
        
    }
    function indexAction(){
        return [
            'titulo'=>'Login',
            'form' => new LoginForm("login"),
            'identity'=>$this->login->getIdentity()
        ];
    }
    function autenticarAction(){
        if(!$this->request->isPost()){
            $this->redirect->toRoute('login',['action'=>'index']);
        }
        $form = new LoginForm("login");
        $form->setInputFilter(new LoginValidator());
        
        //obtenemos los datos desde el formulario con post data
        $data = $this->request->getPost();
        $form->setData($data);
        
        //validando el form
        if(!$form->isValid()){
            $modelView = new ViewModel(['titulo'=>'Login','firn'=>$form]);
            return $modelView;
        }
        $values = $form->getData();
        
        try{
           $this->login->setMessage('El nombre de Usuario y Password no coinciden.', LoginService::NOT_IDENTITY);
            $this->login->setMessage('La contraseÃ±a ingresada es incorrecta. IntÃ©ntelo de nuevo.', LoginService::INVALID_CREDENTIAL);
            $this->login->setMessage('Los campos de Usuario y Password no pueden dejarse en blanco.', LoginService::INVALID_LOGIN);
            $this->login->login($values['email'], $values['password']);

            $this->flashMessenger()->addSuccessMessage('Has iniciado sesiÃ³n con Ã©xito.');
            return $this->redirect()->toRoute('login', ['action' => 'success']);
            
        } catch (Exception $ex) {
            $this->flashMessenger()->addErrorMessage('Login con error');
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('login', ['action' => 'index']);
        }
        
    }
    function successAction(){
        return ['titulo'=>'página de exito'];
    }
    function logoutAction(){
        $this->login->logout();
        $this->flashMessenger()->addSuccessMessage('Has cerrado la sesión con éxito');
        return $this->redirect()-toRoute('login',['action'=>'index']);
    }
}
