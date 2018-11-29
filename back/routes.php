<?php
declare(strict_types=1);

use app\base\Authentication;
use app\controllers\DepartmentController;
use app\controllers\ServicesController;
use app\actions\IndexAction;
use app\controllers\WorkerController;
use app\middlewares\ModelPager;
use app\middlewares\ModelSorter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Tuupola\Middleware\JwtAuthentication;

/**
 * @var App $app
 */

$app->add(new JwtAuthentication([
    'secret' => $app->getContainer()->get('settings')['jwtSecret'],
    'secure' => false,
    'algorithm' => 'HS512',
    'error' => function (RequestInterface $request, ResponseInterface $response, $args) {
        return $response
            ->withStatus(401)
            ->withBody($args['message']);
    },
    'rules' => [
        function (RequestInterface $request) {
            return in_array($request->getMethod(), ['POST', 'PUT', 'DELETE']) || preg_match('@api/profile@', $request->getUri()->getPath());
        }
    ],
    'callback' => Authentication::class
]));

$app->any('/', IndexAction::class);

$app->group('/api', function () use ($app) {

    $app->get('/service', ServicesController::class . ':list')
        ->add(ModelPager::class)
        ->add(ModelSorter::class);
    $app->get('/service/{id:\d+}', ServicesController::class . ':show');

    $app->get('/worker', WorkerController::class . ':list')
        ->add(ModelPager::class)
        ->add(ModelSorter::class);
    $app->get('/worker/{id:\d+}', WorkerController::class . ':show');

    $app->get('/department', DepartmentController::class . ':list')
        ->add(ModelPager::class)
        ->add(ModelSorter::class);
    $app->get('/department/{id:\d+}', DepartmentController::class . ':show');
});

$app->any('/{path:.+}', IndexAction::class);