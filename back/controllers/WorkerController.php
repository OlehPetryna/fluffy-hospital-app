<?php
declare(strict_types=1);

namespace app\controllers;

use app\domain\Department;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

class DepartmentController
{
    /**@var EntityManager $entityManager*/
    private $entityManager;
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function list(Request $request, Response $response, array $args)
    {
        $services = $this->entityManager->getRepository(Department::class)->findAll();
        return $response->withJson($services, 200);
    }

    public function show(Request $request, Response $response, array $args)
    {
        return $response->withJson(
            $this->entityManager->getRepository(Department::class)->find($args['id']),
            200);
    }
}