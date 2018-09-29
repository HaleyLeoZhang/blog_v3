<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth_admin' => \App\Http\Middleware\AdminMiddleware::class,
        'auth_user'  => \App\Http\Middleware\UserMiddleware::class,
        'check_user' => \App\Http\Middleware\CheckUserMiddleware::class,
        'api'        => \App\Http\Middleware\ApiMiddleware::class,
    ];
}
