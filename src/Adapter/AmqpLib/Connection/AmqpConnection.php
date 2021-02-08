<?php

declare(strict_types=1);

namespace FiveLab\Component\Amqp\Adapter\AmqpLib\Connection;

use FiveLab\Component\Amqp\Connection\ConnectionInterface;
use PhpAmqpLib\Connection\AbstractConnection;
use SplObserver;

/**
 * The connection provided via php-amqplib library.
 */
class AmqpConnection implements ConnectionInterface, \SplSubject
{
    /**
     * @var \SplObserver[]
     */
    private $observers = [];

    /**
     * @var AbstractConnection
     */
    private $connection;

    /**
     * @var float
     */
    private $readTimeout;

    /**
     * @param AbstractConnection $connection
     * @param float              $readTimeout
     */
    public function __construct(AbstractConnection $connection, float $readTimeout)
    {
        $this->connection = $connection;
        $this->readTimeout = $readTimeout;
    }

    /**
     * Closes connection
     * @throws \Exception
     */
    public function __destruct()
    {
        $this->connection->close();
    }

    /**
     * Returns original connection
     * This method establishes the connection
     *
     * @return AbstractConnection
     */
    public function getConnection(): AbstractConnection
    {
        return $this->connection;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(): void
    {
        if (!$this->connection->isConnected()) {
            $this->connection->reconnect();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isConnected(): bool
    {
        return $this->connection && $this->connection->isConnected();
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function disconnect(): void
    {
        $this->connection->close();

        $this->notify();
    }

    /**
     * {@inheritdoc}
     */
    public function reconnect(): void
    {
        $this->disconnect();
        $this->connect();
    }

    /**
     * {@inheritdoc}
     */
    public function setReadTimeout(float $timeout): void
    {
        $this->readTimeout = $timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function getReadTimeout(): float
    {
        return $this->readTimeout;
    }

    /**
     * {@inheritdoc}
     */
    public function attach(SplObserver $observer)
    {
        $hash = \spl_object_hash($observer);

        if (!\array_key_exists($hash, $this->observers)) {
            $this->observers[\spl_object_hash($observer)] = $observer;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function detach(SplObserver $observer)
    {
        unset($this->observers[\spl_object_hash($observer)]);
    }

    /**
     * {@inheritdoc}
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}
