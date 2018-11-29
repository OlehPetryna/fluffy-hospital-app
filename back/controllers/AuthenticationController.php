<?php
declare(strict_types=1);

namespace app\controllers;


use app\base\Authentication;
use app\domain\User;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthenticationController
{
    /**@var EntityManager $entityManager*/
    private $entityManager;

    /**@var Authentication $authentication*/
    private $authentication;
    public function __construct(EntityManager $entityManager, Authentication $authentication) {
        $this->entityManager = $entityManager;
        $this->authentication = $authentication;
    }

    public function login(Request $request, Response $response, array $args): Response
    {
        $user = $this->authentication->authenticate($request->getParsedBodyParam('login'), $request->getParsedBodyParam('password'));
        return $response->withJson($user ?: $this->authentication->getLastError(), $user ? 200 : 401);
    }
}