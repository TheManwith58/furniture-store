protected $routeMiddleware = [
    // ...
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'localization' => \App\Http\Middleware\Localization::class,
];