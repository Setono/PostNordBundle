<?php

declare(strict_types=1);

namespace Setono\PostNordBundle\DependencyInjection\Compiler;

use Buzz\Client\BuzzClientInterface;
use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

final class RegisterHttpClientPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $serviceId = 'setono_post_nord.http_client';

        if($container->hasParameter('setono_post_nord.http_client')) {
            if(!$container->has($container->getParameter('setono_post_nord.http_client'))) {
                throw new ServiceNotFoundException($container->getParameter('setono_post_nord.http_client'));
            }

            $container->setAlias($serviceId, $container->getParameter('setono_post_nord.http_client'));
        } elseif($container->has(BuzzClientInterface::class)) {
            $container->setAlias($serviceId, BuzzClientInterface::class);
        } else {
            throw new InvalidArgumentException('You need to set the parameter setono_post_nord.http_client. You can also run composer req kriswallsmith/buzz and it will work automatically.');
        }
    }
}
