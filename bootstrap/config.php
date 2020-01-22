<?php

use function DI\create;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use App\Game;
use App\Contracts\QuestionsDeckInterface;
use App\Contracts\CategoryInterface;
use App\Deck\QuestionsDeck;
use App\Deck\Category;

return [
	QuestionsDeckInterface::class => create(QuestionsDeck::class)
		->constructor(
			\DI\create(Category::class)->constructor(CategoryInterface::POP),
			\DI\create(Category::class)->constructor(CategoryInterface::SCIENCE),
			\DI\create(Category::class)->constructor(CategoryInterface::SPORT),
			\DI\create(Category::class)->constructor(CategoryInterface::ROCK)
		),

	LoggerInterface::class => create(Logger::class)
        ->constructor('trivia', [new StreamHandler('php://stdout', Logger::DEBUG)]),

	Game::class => create(Game::class)
        ->constructor(\DI\get(QuestionsDeckInterface::class), \DI\get(LoggerInterface::class)),
];