<?php
declare(strict_types=1);

use app\controllers\DepartmentController;
use app\controllers\ServicesController;
use app\routes\IndexAction;
use Slim\App;
/**
 * @var App $app
 */

$app->any('/', IndexAction::class);

$app->group('/api', function () use ($app) {
    $app->get('/service', ServicesController::class, ':list');
    $app->get('/department', DepartmentController::class, ':list');
});

$app->redirect('/{path:.+}', '/');
