<?php
namespace Usuario;

//use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\UsuarioController::class => Controller\ControllerFactory::class,
            Controller\LoginController::class => Controller\ControllerFactory::class,

        ],
    ],
    'router' => [
        'routes' => [
            'formulario' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/formulario[/:action]',
                    'defaults' => [
                        //'controller' => Controller\LoginController::class,
                        'controller' => Controller\UsuarioController::class,
                        'action' => 'index',
                    ],
                ],
            ],
             'login' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/login[/:action]',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'index',
                    ],
                ],
            ],  
            
            'usuario' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/usuario[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller'    => Controller\UsuarioController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'usuario.paginator' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/usuario/[page/:page]',
                    'defaults' => [
                        'page' => 1,
                        'controller' => Controller\UsuarioController::class,
                        'action' => 'listar',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Usuario' => __DIR__ . '/../view',
        ],
    ],
];
