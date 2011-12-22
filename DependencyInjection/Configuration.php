<?php

namespace drymek\PheanstalkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('drymek_pheanstalk');

        $rootNode
            ->children()
                ->scalarNode('server')->defaultValue('127.0.0.1')->end()
                ->scalarNode('port')->defaultValue('11300')->end()
                ->scalarNode('timeout')->defaultValue(null)->end()
            ->end();
        return $treeBuilder;
    }
}
