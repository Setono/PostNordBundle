<?php

declare(strict_types=1);

namespace Setono\PostNordBundle;

use Setono\PostNordBundle\DependencyInjection\Compiler\RegisterFactoriesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoPostNordBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterFactoriesPass());
    }
}
