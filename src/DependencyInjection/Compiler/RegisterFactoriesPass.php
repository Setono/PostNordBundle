<?php

declare(strict_types=1);

namespace Setono\PostNordBundle\DependencyInjection\Compiler;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

final class RegisterFactoriesPass implements CompilerPassInterface
{
    private const PSR17_FACTORY_SERVICE_ID = 'setono_post_nord.psr17_factory';

    public function process(ContainerBuilder $container): void
    {
        if (class_exists(Psr17Factory::class)) {
            // this service is used later if the Psr17Factory exists. Else it will be automatically removed by Symfony
            $container->register(self::PSR17_FACTORY_SERVICE_ID, Psr17Factory::class);
        }

        $this->registerFactory($container, 'setono_post_nord.request_factory', 'setono_post_nord.request_factory', RequestFactoryInterface::class);
        $this->registerFactory($container, 'setono_post_nord.stream_factory', 'setono_post_nord.stream_factory', StreamFactoryInterface::class);
    }

    private function registerFactory(ContainerBuilder $container, string $parameter, string $service, string $factoryInterface): void
    {
        if ($container->hasParameter($parameter)) {
            if (!$container->has($container->getParameter($parameter))) {
                throw new ServiceNotFoundException($container->getParameter($parameter));
            }

            $container->setAlias($service, $container->getParameter($parameter));
        } elseif ($container->has($factoryInterface)) {
            $container->setAlias($service, $factoryInterface);
        } elseif ($container->has('nyholm.psr7.psr17_factory')) {
            $container->setAlias($service, 'nyholm.psr7.psr17_factory');
        } elseif (class_exists(Psr17Factory::class)) {
            $container->setAlias($service, self::PSR17_FACTORY_SERVICE_ID);
        }
    }
}
