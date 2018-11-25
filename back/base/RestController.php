<?php
declare(strict_types=1);

namespace app\base;


use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class RestController
{
    public $entityClass;

    /**@var EntityManager $entityManager*/
    private $entityManager;
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function list(Request $request, Response $response, array $args): Response
    {
        $models = $this->entityManager->getRepository($this->entityClass)->findAll();
        return $response->withJson($models, $models ? 200 : 404);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $model = $this->entityManager->getRepository($this->entityClass)->find($args['id']);
        return $response->withJson($model, $model ? 200 : 404);
    }
}