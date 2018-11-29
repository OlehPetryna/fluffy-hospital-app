<?php
declare(strict_types=1);

namespace app\base;


use app\domain\User;
use Doctrine\ORM\EntityManager;
use Firebase\JWT\JWT;
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

        if (!$user || !$this->validateJWT($jwt)) {
            throw new \HttpException('Invalid token', 401);
        }

        $this->container['userIdentity'] = $user;
    }

    public function encryptPassword(string $raw): string {
        return password_hash($raw, PASSWORD_DEFAULT);
    }

    public function validatePassword(string $raw, string $hash): bool {
        return password_verify($raw, $hash);
    }

    public function validateJWT(array $jwt): bool {
        return time() > $jwt['exp'];
    }

    public function generateJWT(User $user): string {
        $time = new \DateTime();
        $futureTime = new \DateTime('now +3 hours');
        $body = [
            'uid' => $user->getId(),
            'iat' => $time->getTimestamp(),
            'exp' => $futureTime->getTimestamp(),
        ];

        return JWT::encode($body, $this->container['settings']['jwtSecret'],'HS512');
    }

    private $errors = [];
    public function authenticate(string $login, string $rawPassword): ?User {
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $login]);
        if ($user) {
            if ($this->validatePassword($rawPassword, $user->getPassword())) {
                $this->container['userIdentity'] = $user;
                return $user;
            } else {
                $this->errors = 'Invalid password';
            }
        } else {
            $this->errors = 'Invalid login';
        }

        return null;
    }

    public function getLastError() {
        return $this->errors ?? null;
    }
}