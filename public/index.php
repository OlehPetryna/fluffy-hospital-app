<?php
declare(strict_types=1);
require '../back/vendor/autoload.php';

$settings = require_once '../back/bootstrap.php';

$app = new \Slim\App($settings);

require_once '../back/routes.php';


$app->run();