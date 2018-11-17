<?php
declare(strict_types=1);

namespace app\base;


use Psr\Container\ContainerInterface;

class BaseObject
{
    /**@var ContainerInterface $container*/
    protected $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}