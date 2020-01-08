<?php

$routes = [
    'list-examples' => (object)[
        'urls' => [ 'en_US.UTF8' => '/list-examples' ],
        'module' => 'Bitendian\JWT\Example\Modules\ListExamples\ListExamplesWidget',
        'layout' => 'Bitendian\JWT\Example\Layouts\EmptyLayout',
        'roles' => [ 'Basic' ]
    ],
    'generate-token' => (object)[
        'urls' => [ 'en_US.UTF8' => '/generate-token' ],
        'module' => 'Bitendian\JWT\Example\Modules\GenerateToken\GenerateTokenWidget',
        'layout' => 'Bitendian\JWT\Example\Layouts\EmptyLayout',
        'roles' => [ 'Basic' ]
    ],
    'token-process' => (object)[
        'urls' => [ 'en_US.UTF8' => '/token-process' ],
        'module' => 'Bitendian\JWT\Example\Modules\TokenProcess\TokenProcessWidget',
        'layout' => 'Bitendian\JWT\Example\Layouts\EmptyLayout',
        'roles' => [ 'Basic' ]
    ],
    'client-flow' => (object)[
        'urls' => [ 'en_US.UTF8' => '/client-flow' ],
        'module' => 'Bitendian\JWT\Example\Modules\ClientFlow\ClientFlowWidget',
        'layout' => 'Bitendian\JWT\Example\Layouts\EmptyLayout',
        'roles' => [ 'Basic' ]
    ],
    'api-auth' => (object)[
        'urls' => [ 'en_US.UTF8' => '/api/auth' ],
        'module' => 'Bitendian\JWT\Example\Modules\Rests\AuthApiRest',
        'layout' => 'Bitendian\JWT\Example\Layouts\ApiRestLayout',
        'roles' => [ 'Basic' ]
    ],
    'api-example' => (object)[
        'urls' => [ 'en_US.UTF8' => '/api/example' ],
        'module' => 'Bitendian\JWT\Example\Modules\Rests\ExampleApiRest',
        'layout' => 'Bitendian\JWT\Example\Layouts\ApiRestLayout',
        'roles' => [ 'Basic' ]
    ],
];
