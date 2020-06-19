<?php

declare(strict_types=1);

namespace FiveLab\Component\Amqp\Tests\Unit\Consumer\Spool;

use FiveLab\Component\Amqp\Consumer\Spool\SpoolConsumerConfiguration;
use PHPUnit\Framework\TestCase;

class SpoolConsumerConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFailConstructionWhenTimeoutIsUnlimited(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('can\'t be less than ~0.1');

        new SpoolConsumerConfiguration(10, 0, 0.0);
    }
}