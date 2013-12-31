<?php

namespace Kutny\FixturesBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KutnyFixturesExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('kutny_fixtures.appdata_manager_service_name', $config['appdata_manager_service_name']);
        $container->setParameter('kutny_fixtures.doctrine_connection_service_name', $config['doctrine_connection_service_name']);
    }

}
