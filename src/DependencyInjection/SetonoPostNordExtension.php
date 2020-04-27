<?php

declare(strict_types=1);

namespace Setono\PostNordBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoPostNordExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('setono_post_nord.api_key', $config['api_key']);
        $container->setParameter('setono_post_nord.base_url', $config['base_url']);

        if (isset($config['http_client'])) {
            $container->setParameter('setono_post_nord.http_client', $config['http_client']);
        }

        if (isset($config['request_factory'])) {
            $container->setParameter('setono_post_nord.request_factory', $config['request_factory']);
        }

        if (isset($config['stream_factory'])) {
            $container->setParameter('setono_post_nord.stream_factory', $config['stream_factory']);
        }

        $loader->load('services.xml');
    }
}
