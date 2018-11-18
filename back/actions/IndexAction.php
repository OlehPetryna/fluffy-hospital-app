<?php
declare(strict_types=1);

namespace app\routes;


use app\base\BaseObject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class IndexAction extends BaseObject
{
    public function __invoke(Request $request, Response $response, $args)
    {
        ob_start();
        require '../../public/index.html';
        $content = ob_get_contents();
        ob_end_clean();
        $response->getBody()->write($content);
        return $response;
    }
}