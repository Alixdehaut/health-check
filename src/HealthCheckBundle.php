<?php

namespace Tseguier\HealthCheckBundle;

use Tseguier\HealthCheckBundle\DependencyInjection\Compiler\HealthCheckerPass;
use Tseguier\HealthCheckBundle\HealthCheckInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HealthCheckBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->registerForAutoconfiguration(HealthCheckInterface::class)->addTag(HealthCheckInterface::TAG);
    }
}
