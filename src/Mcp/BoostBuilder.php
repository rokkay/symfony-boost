<?php

namespace Rokkay\SymfonyBoostBundle\Mcp;

use Rokkay\SymfonyBoostBundle\Mcp\Tools\ApplicationInfo;
use Symfony\AI\McpSdk\Capability\PromptChain;
use Symfony\AI\McpSdk\Capability\ResourceChain;
use Symfony\AI\McpSdk\Capability\ToolChain;
use Symfony\AI\McpSdk\Server\NotificationHandler\InitializedHandler;
use Symfony\AI\McpSdk\Server\NotificationHandlerInterface;
use Symfony\AI\McpSdk\Server\RequestHandler\InitializeHandler;
use Symfony\AI\McpSdk\Server\RequestHandler\PingHandler;
use Symfony\AI\McpSdk\Server\RequestHandler\PromptGetHandler;
use Symfony\AI\McpSdk\Server\RequestHandler\PromptListHandler;
use Symfony\AI\McpSdk\Server\RequestHandler\ResourceListHandler;
use Symfony\AI\McpSdk\Server\RequestHandler\ResourceReadHandler;
use Symfony\AI\McpSdk\Server\RequestHandler\ToolCallHandler;
use Symfony\AI\McpSdk\Server\RequestHandler\ToolListHandler;
use Symfony\AI\McpSdk\Server\RequestHandlerInterface;

readonly class BoostBuilder {

    /**
     * @return array<RequestHandlerInterface>
     */
    public static function buildRequestHandlers(): array
    {
        $promptManager = new PromptChain([]);
        $resourceManager = new ResourceChain([]);

        $toolManager = new ToolChain([
            new ApplicationInfo(),
        ]);

        return [
            new InitializeHandler('symfony-boost'),
            new PingHandler(),
            new PromptListHandler($promptManager),
            new PromptGetHandler($promptManager),
            new ResourceListHandler($resourceManager),
            new ResourceReadHandler($resourceManager),
            new ToolCallHandler($toolManager),
            new ToolListHandler($toolManager),
        ];
    }

    /**
     * @return list<NotificationHandlerInterface>
     */
    public static function buildNotificationHandlers(): array
    {
        return [
            new InitializedHandler(),
        ];
    }

}