<?php
declare(strict_types=1);

namespace app\providers;


use app\base\Authentication;
use app\controllers\DepartmentController;
use app\controllers\ServicesController;
use app\controllers\WorkerController;
use Doctrine\ORM\EntityManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Slim implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple[DepartmentController::class] = function (Container $container): DepartmentController {
            return new DepartmentController($container[EntityManager::class]);
        };

        $pimple[WorkerController::class] = function (Container $container): WorkerController {
            return new WorkerController($container[EntityManager::class]);
        };

        $pimple[ServicesController::class] = function (Container $container): ServicesController {
            return new ServicesController($container[EntityManager::class]);
        };

        $pimple[Authentication::class] = function (Container $container): Authentication {
            return new Authentication($container[EntityManager::class], $container);
        };

    }
}