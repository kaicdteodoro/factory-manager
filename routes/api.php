<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SampleController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')
    ->group(static function (Router $router) {
        $router->post('logout', [AuthController::class, 'logout']);

        $router->controller(OrderController::class)
            ->prefix('orders')
            ->group(static function (Router $router) {
                $router->get('/', 'orders');
                $router->post('/', 'create');
                $router->post('/{id}', 'update');
                $router->delete('/{id}', 'delete');
                $router->get('/status', 'status');
                $router->get('/numbers', 'numbers');
                $router->get('/chart/month', 'chartMonth');
            });

        $router->controller(SampleController::class)
            ->prefix('samples')
            ->group(static function (Router $router) {
                $router->get('/', 'samples');
                $router->post('/', 'create');
                $router->post('/{id}', 'update');
                $router->delete('/{id}', 'delete');
                $router->get('/values', 'values');
            });
    });

Route::post('login', [AuthController::class, 'login']);

