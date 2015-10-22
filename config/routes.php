<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('DashedRoute');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    $routes->connect ('/usuarios', array('controller'=>'users','action'=>'index'), ['routeClass' => 'InflectedRoute']);
    $routes->connect('/usuarios/:action/*', ['controller' => 'Users'], ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/usuarios/apagar/*', array('controller'=>'users','action'=>'delete'), ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/usuarios/ver/*', array('controller'=>'users','action'=>'view'), ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/usuarios/editar/*', array('controller'=>'users','action'=>'edit'), ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/usuarios/adicionar/*', array('controller'=>'users','action'=>'add'), ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/usuarios/senha/*', array('controller'=>'users','action'=>'password'), ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/login/*', array('controller'=>'users','action'=>'login'), ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/logout/*', array('controller'=>'users','action'=>'logout'), ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/resetar-senha/*', array('controller'=>'users','action'=>'resetPW'), ['routeClass' => 'InflectedRoute']);
    $routes->connect ('/esqueci-a-senha/*', array('controller'=>'users','action'=>'recovery'), ['routeClass' => 'InflectedRoute']);
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
