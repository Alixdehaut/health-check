<?php

namespace Tseguier\HealthCheckBundle\DependencyInjection;

use Tseguier\HealthCheckBundle\Controller\HealthCheckController;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class HealthCheckExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
        $def = $container->getDefinition(HealthCheckController::class);
        $args = $def->getArguments();

        $args[] = $config['date_format'];

        $def = new Definition(HealthCheckController::class, $args);
        $def->addTag('controller.service_arguments');

        $container->addDefinitions([HealthCheckController::class => $def]);
    }
}
