<?php
namespace Album;

use Zend\Router\Http\Segment;
//use Zend\ServiceManager\Factory\InvokableFactory;

return [
    /*  No entiendo por qué no funciona si descomento esto.
        Se supone que debo registrar mis controllers acá:
        Pero, si los registro me manda error.

        'controllers' => [
        'factories' => [
            Controller\AlbumController::class => InvokableFactory::class,
        ],
    ],
    */
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'album' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [

        
    
            'strategies' => [
                'ViewJsonStrategy',
  
        ],


        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
];