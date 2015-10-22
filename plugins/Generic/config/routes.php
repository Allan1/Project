<?php
use Cake\Routing\Router;

Router::plugin('Generic', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
