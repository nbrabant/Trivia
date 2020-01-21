<?php

use function DI\create;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use App\Game;

return [
	LoggerInterface::class => create(Logger::class)
        ->constructor('trivia', [new StreamHandler('php://stdout', Logger::DEBUG)]),

	Game::class => create(Game::class)
        ->constructor(\DI\get(LoggerInterface::class)),
];