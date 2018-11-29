<?php
declare(strict_types=1);

namespace app\base;


use app\domain\User;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Pimple\Container;

class Authentication
{
    /**@var EntityManager $em*/
    private $em;
    /**@var Container $container*/
    private $container;
    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, $args)
    {
        $jwt = $args['decoded'];
        $user = $this->em->getRepository(User::class)->find($jwt['uid'] ?? null);

        if (!$user) {
            throw new \HttpException('Invalid token', 401);
        }

        $this->container['userIdentity'] = $user;
    }
}