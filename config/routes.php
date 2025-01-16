<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

//Define routes
$routes = Router::createRouteBuilder('/');

//Home Page
$routes->connect('/', ['controller' => 'Main', 'action' => 'home'], ['_name' => 'home']);

//Products Page (Index, Add, Edit & Delete)
$routes->connect('/products', ['controller' => 'Products', 'action' => 'index'], ['_name' => 'products.index']);
$routes->connect('/product/add', ['controller' => 'Products', 'action' => 'addEdit'],
                    [
                        '_method' => ['GET', 'POST'],
                        '_name' => 'product.add'
                    ]
                );
$routes->connect(
        '/product/edit/{productId}/{productSlug}',
        ['controller' => 'Products', 'action' => 'addEdit'],
        [
            '_method' => ['GET', 'POST'],
            'pass' => ['productId', 'productSlug'], //Pass parameters to the controller
            'patterns' => [
                'productId' => '[0-9]+',
            ],
            'defaults' => ['productSlug' => NULL],
            '_name' => 'product.edit'
        ]
    );
$routes->connect(
        '/product/delete/{productId}/{productSlug}',
        ['controller' => 'Products', 'action' => 'delete'],
        [
            'pass' => ['productId', 'productSlug'], //Pass parameters to the controller
            'patterns' => [
                'productId' => '[0-9]+',
            ],
            'defaults' => ['productSlug' => NULL],
            '_name' => 'product.delete'
        ]
    );