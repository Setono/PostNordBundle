<?php

declare(strict_types=1);

namespace Tests\Setono\PostNordBundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\PostNord\Client\Client;
use Setono\PostNord\Client\ClientInterface;
use Setono\PostNordBundle\DependencyInjection\SetonoPostNordExtension;

final class SetonoPostNordExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new SetonoPostNordExtension()];
    }

    protected function getMinimalConfiguration(): array
    {
        return ['api_key' => 'api key'];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameter_has_been_set(): void
    {
        $this->load([
            'base_url' => 'base_url',
            'http_client' => 'http_client_service_id',
            'request_factory' => 'request_factory_service_id',
            'stream_factory' => 'stream_factory_service_id',
        ]);

        $this->assertContainerBuilderHasParameter('setono_post_nord.api_key', 'api key');
        $this->assertContainerBuilderHasParameter('setono_post_nord.base_url', 'base_url');
        $this->assertContainerBuilderHasParameter('setono_post_nord.http_client', 'http_client_service_id');
        $this->assertContainerBuilderHasParameter('setono_post_nord.request_factory', 'request_factory_service_id');
        $this->assertContainerBuilderHasParameter('setono_post_nord.stream_factory', 'stream_factory_service_id');
    }

    /**
     * @test
     */
    public function after_loading_the_services_exist(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService('setono_post_nord.client', Client::class);
    }

    /**
     * @test
     */
    public function after_loading_the_aliases_exist(): void
    {
        $this->load();

        $this->assertContainerBuilderHasAlias(ClientInterface::class, 'setono_post_nord.client');
    }
}
