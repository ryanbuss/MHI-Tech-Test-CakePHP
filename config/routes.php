<?php

use Cake\Routing\Router;

//Define routes
$routes = Router::createRouteBuilder('/');

//Home Page
$routes->connect(
    '/',
    ['controller' => 'Main', 'action' => 'home'],
    ['_name' => 'home']
);

//Product Pages - Index
$routes->connect(
    '/products',
    ['controller' => 'Products', 'action' => 'index'],
    ['_name' => 'products.index']
);

//Product Pages - Add
$routes->connect(
    '/product/add',
    ['controller' => 'Products', 'action' => 'addEdit'],
    [
        '_method' => [
            'GET', //Allow GET method
            'POST' //Allow POST method - for form submission
        ],
        '_name' => 'product.add'
    ]
);

//Products Page - Edit
$routes->connect(
    '/product/edit/{productId}/{productSlug}',
    ['controller' => 'Products', 'action' => 'addEdit'],
    [
        '_method' => [
            'GET', //Allow GET method
            'POST' //Allow POST method - for form submission
        ],
        'pass' => ['productId'], //Pass 1 parameters to the controller
        'patterns' => ['productId' => '[0-9]+'], //Any characters 0-9, multiple digits allowed
        '_name' => 'product.edit'
    ]
);

//Products Page - Delete
$routes->connect(
    '/product/delete/{productId}/{productSlug}',
    ['controller' => 'Products', 'action' => 'delete'],
    [
        'pass' => ['productId'], //Pass 1 parameters to the controller
        'patterns' => ['productId' => '[0-9]+'], //Any characters 0-9, multiple digits allowed
        '_name' => 'product.delete'
    ]
);
