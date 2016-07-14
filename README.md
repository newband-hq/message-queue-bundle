# Newband Message Queue Bundle

### Version
1.0.0

### Installation

First add the dependencies to your `composer.json` file:

    "require": {
        ...
        "newband/message-queue-bundle": "dev-master"
    },

Then install the bundle with the command:

    php composer update

Enable the bundle in your application kernel:

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new \Newband\Bundle\MessageQueueBundle\MessageQueueBundle(),
        );
    }
    
### Configuration

    // app/config/config.yml
    
    ... 
    newband_mqueue:
        sqs:
            arguments:
                region: aws region
                version: latest
                credentials: 
                    key: key
                    secret: secret
            queue:
                queue_any_key1:
                    name: queue name
                queue_any_key2:
                    name: queue name
                ...
        
### Usage

    $queueClient = $this->get('newband_mqueue.sqs.queue_any_key1');