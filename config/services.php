<?php

use Rokkay\SymfonyBoostBundle\Command\StartCommand;
use Rokkay\SymfonyBoostBundle\Mcp\BoostBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container):void
{
    $container->services()
        ->set('boost.mcp', BoostBuilder::class)

        ->set('boost.command.start', StartCommand::class)
            ->args([
                service('logger'),
            ])
            ->tag('console.command');
};