<?php

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\SetUpPanel;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filament Panel
    |--------------------------------------------------------------------------
    */
    'default_panel' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Panels
    |--------------------------------------------------------------------------
    */
    'panels' => [

        'admin' => [
            'id' => 'admin',
            'path' => 'admin', // URL will be /admin
            'domain' => null,

            /*
            |--------------------------------------------------------------------------
            | Authentication (use Breeze guard + login)
            |--------------------------------------------------------------------------
            */
            'auth' => [
                'guard' => 'web', // Use Breeze's 'web' guard
                'pages' => [
                    'login' => \App\Http\Controllers\Auth\AuthenticatedSessionController::class, // Use Breeze login page
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Middleware
            |--------------------------------------------------------------------------
            */
            'middleware' => [
                'web',
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DispatchServingFilamentEvent::class,
                DisableBladeIconComponents::class,
                SetUpPanel::class,
            ],

            'auth_middleware' => [
                Authenticate::class,
            ],

            /*
            |--------------------------------------------------------------------------
            | Features and UI
            |--------------------------------------------------------------------------
            */
            'features' => [
                'profile' => true,
                'notifications' => true,
                'dark_mode' => true,
            ],

            'resources' => [],
            'pages' => [],
            'widgets' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Settings
    |--------------------------------------------------------------------------
    */
    'assets' => [],
    'dark_mode' => false,
    'database_notifications' => [
        'enabled' => true,
        'color' => 'success',
        'icon' => 'heroicon-o-bell',
    ],
];
