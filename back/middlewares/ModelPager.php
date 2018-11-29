<?php
declare(strict_types=1);

namespace app\middlewares;


use http\Exception\InvalidArgumentException;
use Slim\Http\Request;
use Slim\Http\Response;

class ModelPager
{
    private $pageParamName = 'page';
    private $pageSizeParamName = 'page-size';

    private $defaultPageSize = 20;

    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($page = $request->getQueryParam($this->pageParamName)) {
            $size = $request->getQueryParam($this->pageSizeParamName, $this->defaultPageSize);

            --$page; //not zero-based, so first page really should be first

            $offset = $size * $page;
            $limit = $size;

            $request = $request
                ->withAttribute('offsetQuery', $offset)
                ->withAttribute('limitQuery', $limit);
        }

        return $next($request, $response);
    }
}