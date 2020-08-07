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

namespace FiveLab\Component\Amqp\Tests\Unit\Consumer\Tag;

use FiveLab\Component\Amqp\Consumer\Tag\EmptyConsumerTagGenerator;
use PHPUnit\Framework\TestCase;

class EmptyConsumerTagGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSuccessGenerate(): void
    {
        $generator = new EmptyConsumerTagGenerator();

        self::assertEquals('', $generator->generate());
    }
}
