<?php

namespace Newband\Bundle\MessageQueueBundle\Adapter;

use Aws\Sqs\SqsClient;
use Newband\Bundle\MessageQueueBundle\Adapter;
use Newband\Bundle\MessageQueueBundle\Message;

/**
 * Class SqsAdapter
 * @package Newband\Bundle\MessageQueueBundle\Adapter
 * @author Zafar <zafar@newband.com>
 */
class SqsAdapter implements Adapter
{
    /**
     * @var
     */
    private $sqsClient;

    /**
     * @var string
     */
    private $queueName;

    /**
     * @var string
     */
    private $queueUrl;

    /**
     * SqsAdapter constructor.
     * @param SqsClient $sqsClient
     * @param string $queueName
     */
    public function __construct(
        SqsClient $sqsClient,
        $queueName
    ){
        $this->sqsClient = $sqsClient;
        $this->queueName = $queueName;
        $this->queueUrl = $this->sqsClient->getQueueUrl(array('QueueName' => $this->queueName))->get('QueueUrl');
    }

    /**
     * {@inheritdoc}
     */
    public function send(Message $message)
    {
        $this->sqsClient->sendMessage(array(
            'QueueUrl' => $this->queueUrl,
            'MessageBody' => $message->getBody()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Message $message)
    {
        $this->sqsClient->deleteMessage(array(
            'QueueUrl' => $this->queueUrl,
            'ReceiptHandle' => $message->getId()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function receive()
    {
        $result = $this->sqsClient->receiveMessage(array(
            'QueueUrl' => $this->queueUrl
        ));

        if ($result['Message'] == null) {
            return null;
        }

        $message = new Message();
        $message->setId($result['ReceiptHandle']);
        $message->setBody($result['Body']);
        return $message;
    }
}