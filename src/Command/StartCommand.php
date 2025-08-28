<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rokkay\SymfonyBoostBundle\Command;

use Psr\Log\LoggerInterface;
use Rokkay\SymfonyBoostBundle\Mcp\BoostBuilder;
use Symfony\AI\McpSdk\Message\Factory;
use Symfony\AI\McpSdk\Server;
use Symfony\AI\McpSdk\Server\JsonRpcHandler;
use Symfony\AI\McpSdk\Server\Transport\Stdio\SymfonyConsoleTransport;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'boost:mcp', description: 'Starts Symfony BoostBuilder')]
class StartCommand extends Command
{
    public function __construct(private readonly LoggerInterface $logger)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $jsonRpcHandler = new JsonRpcHandler(
            new Factory(),
            BoostBuilder::buildRequestHandlers(),
            BoostBuilder::buildNotificationHandlers(),
            $this->logger,
        );

        $server = new Server($jsonRpcHandler);

        $server->connect(
            new SymfonyConsoleTransport($input, $output)
        );

        return Command::SUCCESS;
    }
}
