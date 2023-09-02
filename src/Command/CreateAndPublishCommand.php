<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\NotificationBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @final since sonata-project/notification-bundle 3.13
 */
class CreateAndPublishCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('sonata:notification:create-and-publish')
            ->addArgument('type', InputArgument::REQUIRED, 'Type of the notification')
            ->addArgument('body', InputArgument::REQUIRED, 'Body of the notification (json)');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');
        $body = json_decode($input->getArgument('body'), true);

        if (null === $body) {
            throw new \InvalidArgumentException('Body does not contain valid json.');
        }

        $this->getContainer()
            ->get('sonata.notification.backend')
            ->createAndPublish($type, $body);

        $output->writeln('<info>Done !</info>');

        return 0;
    }
}
