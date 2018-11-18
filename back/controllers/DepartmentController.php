<?php
declare(strict_types=1);

namespace app\controllers;

use app\base\RestController;
use app\domain\Department;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

class DepartmentController extends RestController
{
    public $entityClass = Department::class;
}