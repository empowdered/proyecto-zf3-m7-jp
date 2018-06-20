<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of FormularioUsuario
 *
 * @author jpmunoz
 */
namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Text;
use Zend\Form\Element\Hidden;

class FormularioUsuario extends Form{
    //put your code here
    public function __construct($name = null) {
        
        parent::__construct($name);
        
          $this->add([
                'name' => 'id',
                'type' => Hidden::class,
            ]);                
        $this->add([
                'name' => 'nombre',
                'type' => Text::class,
                'attributes' => [
                'class' => 'form-control',
                ],
                'options' => [
                'label' => 'nombre completo',
                'label_attributes' => [
                'class' => 'col-sm-2 control-label',
                ],
                ],
                ]);
        $this->add([
                'name' => 'apellido',
                'type' => Text::class,
                'attributes' => [
                'class' => 'form-control',
                ],
                'options' => [
                'label' => 'apellido completo',
                'label_attributes' => [
                'class' => 'col-sm-2 control-label',
                ],
                ],
                ]);
                
        $this->add([
				'type' => Email::class,
                'name' => 'email',
                'attributes' => [
                'class' => 'form-control',
                ],
                'options' => [
                'label' => 'Email',
                'label_attributes' => [
                'class' => 'col-sm-2 control-label',
                ],
                ],
                ]);
        $this->add([
                
                'type' => Text::class,
				'name' => 'username',
                'attributes' => [
                'class' => 'form-control',
                ],
                'options' => [
                'label' => 'nombre usuario completo',
                'label_attributes' => [
                'class' => 'col-sm-2 control-label',
                ],
                ],
                ]);                
        $this->add(['type' => Password::class,
            'name' => 'password',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Password',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ],
            ],
        ]);

        $this->add(['name' => 'send',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Crear',
                'class' => 'btn btn-primary',
            ],
        ]);
        
        $this->add(['name' => 'dim',
            'attributes' => [
                'type' => 'reset',
                'value' => 'Limpiar',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
    
}
