<?php
declare(strict_types=1);

use app\providers\Orm;
use app\providers\Slim;
use Slim\Container;

require_once __DIR__ . '/vendor/autoload.php';

$container = new Container(require __DIR__ . '/settings.php');

$container
    ->register(new Orm())
    ->register(new Slim());

return $container;