<?php

declare(strict_types=1);

namespace Abnermouke\Supports\Frameworks\Hyperf;

use Abnermouke\Supports\Frameworks\Hyperf\Commands\InterfaceCommand;
use Abnermouke\Supports\Frameworks\Hyperf\Commands\PackageCommand;
use Abnermouke\Supports\Frameworks\Hyperf\Commands\SupportsCommand;

class ConfigProvider
{
    
    public function __invoke(): array
    {
        return [
            'commands' => [
                SupportsCommand::class,
                InterfaceCommand::class,
                PackageCommand::class
            ],
            'publish' => [
                [
                    'id' => 'config-builder',
                    'description' => 'The builder config for project',
                    'source' =>  __DIR__.'/../../../configs/builder.php',
                    'destination' => BASE_PATH.'/config/autoload/builder.php'
                ],
                [
                    'id' => 'config-project',
                    'description' => 'The project config for project',
                    'source' =>  __DIR__.'/../../../configs/project.php',
                    'destination' => BASE_PATH.'/config/autoload/project.php'
                ],
                [
                    'id' => 'helpers-response',
                    'description' => 'The response helpers for project',
                    'source' => __DIR__.'/../../../helpers/hyperf/response.php',
                    'destination' => BASE_PATH.'/helpers/response.php'
                ],
                [
                    'id' => 'helpers-project',
                    'description' => 'The project helpers for project',
                    'source' => __DIR__.'/../../../helpers/hyperf/project.php',
                    'destination' => BASE_PATH.'/helpers/project.php'
                ],
                [
                    'id' => 'middleware-base',
                    'description' => 'The base middleware for project',
                    'source' => __DIR__ . '/Middlewares/BaseMiddleware.php',
                    'destination' => BASE_PATH.'/app/Middleware/BaseMiddleware.php'
                ],
            ],
        ];
    }

}