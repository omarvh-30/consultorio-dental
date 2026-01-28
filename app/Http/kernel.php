<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Los middleware globales de la aplicación.
     */
    protected $middleware = [
        // Middleware globales como manejo de CORS, CSRF, etc.
        \App\Http\Middleware\PreventBackHistory::class, // Opcional si quieres que sea global
    ];

    /**
     * Grupos de middleware para rutas
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\PreventBackHistory::class, // aquí también puedes colocarlo
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware individuales para rutas
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
    ];
}
