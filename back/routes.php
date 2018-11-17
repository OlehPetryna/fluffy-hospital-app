<?php
declare(strict_types=1);

use app\routes\IndexRoute;
use Slim\App;
/**
 * @var App $app
 */

$app->any('/', IndexRoute::class);
