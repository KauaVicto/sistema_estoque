<?php

define('ROLE_ADMIN', 1);

define('ROUTES_AUTHORIZATION', [
    2 => [
        'listAllProducts',
        'findProductById',
        'insertProduct',
        'updateProduct',
        'deleteProduct',
        'insertStock',
        'showAllStock',
        'stocksFindByProduct',
        'insertPerson',
    ],
    3 => [
        'listAllProducts',
        'findProductById',
        'insertProduct',
        'updateProduct',
        'deleteProduct',
        'insertStock',
        'showAllStock',
        'stocksFindByProduct',
    ],
    4 => [
        'listAllProducts',
        'findProductById',
        'showAllStock',
        'stocksFindByProduct',
    ]
]);

function verifyAccess($role, $nameRoute) {
    if ($role == ROLE_ADMIN){
        return True;
    }

    if (in_array($nameRoute, ROUTES_AUTHORIZATION[$role])){
        return True;
    }

    return False;

};