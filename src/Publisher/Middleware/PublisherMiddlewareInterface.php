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

namespace FiveLab\Component\Amqp\Publisher\Middleware;

use FiveLab\Component\Amqp\Message\MessageInterface;

/**
 * All publisher middleware should implement this interface.
 */
interface PublisherMiddlewareInterface
{
    /**
     * Handle on middleware layer
     *
     * @param MessageInterface $message
     * @param callable         $next
     * @param string           $routingKey
     */
    public function handle(MessageInterface $message, callable $next, string $routingKey = ''): void;
}
