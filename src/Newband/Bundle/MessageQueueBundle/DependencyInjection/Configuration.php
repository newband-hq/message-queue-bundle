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
                ->append($this->addSqsNode())
            ->end();

        return $treeBuilder;
    }

    private function addSqsNode()
    {
        $treeBuilder = new TreeBuilder();

        $node = $treeBuilder->root('sqs');
        $node
            ->children()
                ->arrayNode('arguments')
                    ->children()
                        ->scalarNode('region')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('version')
                            ->defaultValue('latest')
                        ->end()
                        ->arrayNode('credentials')
                            ->children()
                                ->scalarNode('key')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('secret')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('queues')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $node;
    }
}