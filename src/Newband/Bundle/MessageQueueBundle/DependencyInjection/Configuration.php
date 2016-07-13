<?php

namespace Newband\Bundle\MessageQueueBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Newband\Bundle\MessageQueueBundle\DependencyInjection
 * @author Zafar <zafar@newband.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('newband_mqueue');

        $rootNode
            ->children()
                ->arrayNode('sqs')
                    ->children()
                        ->arrayNode('credentials')
                            ->cannotBeEmpty()
                            ->children()
                                ->scalarNode('key')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('secret')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->scalarNode('region')
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}