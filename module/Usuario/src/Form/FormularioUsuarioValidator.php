<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormularioUsuarioValidator
 *
 * @author jpmunoz
 */
namespace Usuario\Form;

use Zend\InputFilter\InputFilter;
use Zend\Mvc\I18n\Translator as TranslatorMvc;
use Zend\I18n\Translator\Translator;
use Zend\Validator\AbstractValidator;

class FormularioUsuarioValidator extends InputFilter{
    //put your code here
    public function __construct() {
        
        $translator = new TranslatorMvc(new Translator());
        $translator->addTranslationFile('phparray', './module/Application/language/es_ES.php');
        AbstractValidator::setDefaultTranslator($translator);
        
        
        $this->add([
                    'required' => true,
                    'name' => 'nombre',
                    'validators' => [
                    [
                    'name' => 'Alnum',
                    'options' => [
                    'allowWhiteSpace' => true,
                    ],
                    ],
                    ],
                    ]);
        $this->add([
                    'required' => true,
                    'name' => 'apellido',
                    'validators' => [
                    [
                    'name' => 'Alnum',
                    'options' => [
                    'allowWhiteSpace' => true,
                    ],
                    ],
                    ],
                    ]);
        
        $this->add(
                [   'required' => true,
                    'name' => 'email',
                    'validators' => [
                        [
                            'name' => 'EmailAddress',
                        ],
                    ],
        ]);
        
        $this->add([
                    'required' => true,
                    'name' => 'username',
                    'validators' => [
                        [
                            'name' => 'StringLength',
                            'options' => [
                            'min' => 5,
                            'max' => 10,
                            ],
                            ],
                    [
                    'name' => 'Alnum',
                    'options' => [
                    'allowWhiteSpace' => false,
                    ],
                    ],
                    ],
                    ]);
        $this->add(
                [   'required' => true,
                    'name' => 'password',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 4,
                                'max' => 8,
                            ],
                        ],
                        [
                            'name' => 'Alnum',
                        ],
                    ],
        ]);
    }
}
