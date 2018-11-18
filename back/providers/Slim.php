<?php
declare(strict_types=1);

namespace app\providers;


use app\controllers\DepartmentController;
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
    }
}