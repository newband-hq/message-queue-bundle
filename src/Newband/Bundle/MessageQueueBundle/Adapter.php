<?php

namespace Newband\Bundle\MessageQueueBundle;

/**
 * Interface Adapter
 * @package Newband\Bundle\MessageQueueBundle
 * @author Zafar <zafar@newband.com>
 */
interface Adapter
{
    public function send(Message $message);
    public function delete(Message $message);
    public function receive();
}