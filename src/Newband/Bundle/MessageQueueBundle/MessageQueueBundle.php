<?php

namespace Newband\Bundle\MessageQueueBundle;

use Newband\Bundle\MessageQueueBundle\DependencyInjection\MessageQueueExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MessageQueueBundle
 * @package Newband\Bundle\MessageQueueBundle
 * @author Zafar <zafar@newband.com>
 */
class MessageQueueBundle extends Bundle
{
    /**
     * @return MessageQueueExtension
     */
    public function getContainerExtension()
    {
        return new MessageQueueExtension();
    }
}