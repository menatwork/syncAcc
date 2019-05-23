<?php

namespace SyncAccClientBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class MhbExtension
 *
 * @package MhbBundle\DependencyInjection
 */
class SyncAccClientExtension extends Extension
{
    /**
     * @var array
     */
    private $files = [
//        'commands.yml',
//        'listeners.yml',
//        'services.yml'
    ];

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'syncaccclient-bundle';
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        // Add the resource to the container
        parent::getConfiguration($config, $container);
        return new Configuration(
            $container->getParameter('kernel.debug'),
            $container->getParameter('kernel.project_dir'),
            $container->getParameter('kernel.root_dir'),
            $container->getParameter('kernel.default_locale')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        // Load the configurations.
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        // Load the files.
        foreach ($this->files as $file) {
            $loader->load($file);
        }
    }
}
