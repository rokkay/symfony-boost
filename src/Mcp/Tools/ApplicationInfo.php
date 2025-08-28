<?php

namespace Rokkay\SymfonyBoostBundle\Mcp\Tools;
use Symfony\AI\McpSdk\Capability\Tool\IdentifierInterface;
use Symfony\AI\McpSdk\Capability\Tool\MetadataInterface;
use Symfony\AI\McpSdk\Capability\Tool\ToolAnnotationsInterface;
use Symfony\AI\McpSdk\Capability\Tool\ToolCall;
use Symfony\AI\McpSdk\Capability\Tool\ToolCallResult;
use Symfony\AI\McpSdk\Capability\Tool\ToolExecutorInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Process\Process;

class ApplicationInfo implements ToolExecutorInterface, IdentifierInterface, MetadataInterface {

    public const string TITLE = 'Application Info';
    public const string NAME = 'application_info';

    public function call(ToolCall $input): ToolCallResult
    {
        //$process = new Process(['symfony', 'console', 'about']);

        //$process->run();

        return new ToolCallResult(json_encode(
            [
                'php_version' => \PHP_VERSION,
                'php_architecture' => (\PHP_INT_SIZE * 8).' bits',
                'symfony_long_term_support' => 4 === Kernel::MINOR_VERSION ? 'Yes' : 'No',
                'symfony_version' => Kernel::VERSION,
                'symfony_end_of_maintenance' => Kernel::END_OF_MAINTENANCE,
                'symfony_end_of_life' => Kernel::END_OF_LIFE,
                'intl_locale' => class_exists(\Locale::class, false) && \Locale::getDefault() ? \Locale::getDefault() : 'n/a',
                'timezone' => date_default_timezone_get(),
                'opcache_enabled' => \extension_loaded('Zend OPcache'),
                'apcu_enabled' => \extension_loaded('apcu'),
                'xdebug_enabled' => \extension_loaded('xdebug')
            ]
        ));
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDescription(): ?string
    {
        return <<<DESC
            Returns application information including PHP version, Symfony version, environment, timezone, 
            opcache enabled, apcu enabled, xdebug enabled, architecture, Long-Term Support. You should use this tool 
            on each new chat, and use the package & version data to write version specific 
            code for the packages that exist.
        DESC;

    }

    public function getInputSchema(): array
    {
        return [];
    }

    public function getOutputSchema(): ?array
    {
        return [];
    }

    public function getTitle(): ?string
    {
        return self::TITLE;
    }

    public function getAnnotations(): ?ToolAnnotationsInterface
    {
        return null;
    }
}