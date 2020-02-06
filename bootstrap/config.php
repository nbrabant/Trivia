<?php

use function DI\create;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use App\Game;
use App\Contracts\PlayerInterface;
use App\Contracts\BoardInterface;
use App\Contracts\QuestionsDeckInterface;
use App\Contracts\CategoryInterface;
use App\Game\Board;
use App\Game\Player;
use App\Deck\QuestionsDeck;
use App\Deck\Category;

return [
	BoardInterface::class => create(Board::class)
		->constructor(
			\DI\create(Player::class)
		),

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
        ->constructor(
			\DI\get(BoardInterface::class), 
			\DI\get(QuestionsDeckInterface::class), 
			\DI\get(LoggerInterface::class)
		),
];