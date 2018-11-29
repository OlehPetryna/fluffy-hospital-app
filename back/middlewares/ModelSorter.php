<?php
declare(strict_types=1);

namespace app\middlewares;


use http\Exception\InvalidArgumentException;
use Slim\Http\Request;
use Slim\Http\Response;

class ModelSorter
{
    private $sortParamName = 'sort-attribute';
    private $sortDirectionName = 'sort-dir';

    private $directions = [1 => 'ASC', -1 => 'DESC'];

    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($param = $request->getQueryParam($this->sortParamName)) {
            $direction = $this->directions[$request->getQueryParam($this->sortDirectionName, 1)] ?? null;
            if ($direction === null) {
                throw new InvalidArgumentException('Invalid sort direction provided', 403);
            }

            $sort = [$param => $direction];
            $request = $request->withAttribute('sortQuery', $sort);
        }

        return $next($request, $response);
    }
}