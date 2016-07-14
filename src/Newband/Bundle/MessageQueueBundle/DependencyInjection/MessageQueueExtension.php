<?php

namespace Newband\Bundle\MessageQueueBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class MessageQueueExtension
 * @package Newband\Bundle\MessageQueueBundle\DependencyInjection
 * @author Zafar <zafar@newband.com>
 */
class MessageQueueExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->loadAwsSqs($config, $container);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadAwsSqs(array $config, ContainerBuilder $container)
    {
        if (isset($config['sqs'])) {
            $sqsDefinition = new Definition($container->getParameter('aws.sqs.client.class'), array(
                $config['sqs']['arguments'],
            ));
            $container->setDefinition('aws.sqs.client', $sqsDefinition);
            if (isset($config['sqs']['queues'])) {
                $queues = $config['sqs']['queues'];
                $sqsReference = new Reference('aws.sqs.client');
                foreach ($queues as $name => $queue) {
                    $queueId = sprintf('newband_mqueue.sqs.%s', $name);
                    $queueDefinition = new Definition($container->getParameter('newband_mqueue.sqs.class'));
                    $queueDefinition->addArgument($sqsReference);
                    $queueDefinition->addArgument($queue['name']);
                    $container->setDefinition($queueId, $queueDefinition);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'newband_mqueue';
    }
}