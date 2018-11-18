<?php
declare(strict_types=1);

namespace app\controllers;

use app\base\RestController;
use app\domain\Worker;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

class WorkerController extends RestController
{
    public $entityClass = Worker::class;
}