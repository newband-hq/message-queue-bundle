<?php

namespace Newband\Bundle\MessageQueueBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

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

    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'newband-mqueue';
    }
}