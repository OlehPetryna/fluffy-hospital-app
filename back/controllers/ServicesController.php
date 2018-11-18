<?php
declare(strict_types=1);

namespace app\controllers;


use app\base\RestController;
use app\domain\Service;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

class ServicesController extends RestController
{
    public $entityClass = Service::class;
}