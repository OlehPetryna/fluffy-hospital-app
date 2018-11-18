<?php
declare(strict_types=1);

use app\controllers\DepartmentController;
use app\controllers\ServicesController;
use app\actions\IndexAction;
use app\controllers\WorkerController;
use Slim\App;
/**
 * @var App $app
 */

$app->any('/', IndexAction::class);

$app->group('/api', function () use ($app) {
    $app->get('/service', ServicesController::class . ':list');

    $app->get('/worker', WorkerController::class . ':list');
    $app->get('/worker/{id:\d+}', WorkerController::class . ':show');

    $app->get('/department', DepartmentController::class . ':list');
    $app->get('/department/{id:\d+}', DepartmentController::class . ':show');
});

$app->redirect('/{path:.+}', '/');
