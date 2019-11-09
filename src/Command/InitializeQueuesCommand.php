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

namespace FiveLab\Component\Amqp\Command;

use FiveLab\Component\Amqp\Queue\Registry\QueueFactoryRegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The command for initialize queues.
 */
class InitializeQueuesCommand extends Command
{
    private const DEFAULT_NAME = 'event-broker:initialize:queues';

    /**
     * @var QueueFactoryRegistryInterface
     */
    private $registry;

    /**
     * @var array
     */
    private $queues;

    /**
     * Constructor.
     *
     * @param QueueFactoryRegistryInterface $registry
     * @param array                         $queues
     * @param string                        $name
     */
    public function __construct(QueueFactoryRegistryInterface $registry, array $queues, string $name = self::DEFAULT_NAME)
    {
        parent::__construct($name);

        $this->registry = $registry;
        $this->queues = $queues;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Initialize queues.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->queues as $queue) {
            $factory = $this->registry->get($queue);

            $factory->create();

            $output->writeln(\sprintf(
                'Success initialize queue <info>%s</info>.',
                $queue
            ));
        }

        return 0;
    }
}
