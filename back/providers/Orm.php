<?php
declare(strict_types=1);

namespace app\providers;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Orm implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple[EntityManager::class] = function (Container $container): EntityManager {
            $config = Setup::createAnnotationMetadataConfiguration(
                $container['settings']['doctrine']['metadata_dirs'],
                $container['settings']['doctrine']['dev_mode']
            );

            $config->setMetadataDriverImpl(
                new AnnotationDriver(
                    new AnnotationReader,
                    $container['settings']['doctrine']['metadata_dirs']
                )
            );

            $config->setMetadataCacheImpl(
                new FilesystemCache(
                    $container['settings']['doctrine']['cache_dir']
                )
            );

            $em = EntityManager::create(
                $container['settings']['doctrine']['connection'],
                $config
            );

            $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            return $em;
        };

    }
}