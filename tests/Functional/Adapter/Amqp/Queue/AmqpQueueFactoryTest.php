<?php

/*
 * This file is part of the FiveLab Amqp package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

declare(strict_types = 1);

namespace FiveLab\Component\Amqp\Tests\Functional\Adapter\Amqp\Queue;

use FiveLab\Component\Amqp\Adapter\Amqp\Connection\AmqpConnection;
use FiveLab\Component\Amqp\Adapter\Amqp\Queue\AmqpQueueFactory;
use FiveLab\Component\Amqp\Queue\Definition\QueueDefinition;
use FiveLab\Component\Amqp\Queue\QueueFactoryInterface;
use FiveLab\Component\Amqp\Tests\Functional\Adapter\Amqp\Channel\StubAmqpChannelFactory;
use FiveLab\Component\Amqp\Tests\Functional\Adapter\QueueFactoryTestCase;

class AmqpQueueFactoryTest extends QueueFactoryTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createQueueFactory(QueueDefinition $definition): QueueFactoryInterface
    {
        $amqpConnection = new \AMQPConnection([
            'host'         => $this->getRabbitMqHost(),
            'port'         => $this->getRabbitMqPort(),
            'vhost'        => $this->getRabbitMqVhost(),
            'login'        => $this->getRabbitMqLogin(),
            'password'     => $this->getRabbitMqPassword(),
            'read_timeout' => 2,
        ]);

        $connection = new AmqpConnection($amqpConnection);
        $connection->connect();

        $channel = new \AMQPChannel($connection->getConnection());
        $channelFactory = new StubAmqpChannelFactory($connection, $channel);

        return new AmqpQueueFactory($channelFactory, $definition);
    }
}
