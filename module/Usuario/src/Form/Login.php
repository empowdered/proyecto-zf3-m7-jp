<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends Form {

    function __construct($name = null) {
        parent::__construct($name);

        $this->add(['type' => Email::class,
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
                'value' => 'Login',
                'class' => 'btn btn-primary',
            ],
        ]);
    }

}
