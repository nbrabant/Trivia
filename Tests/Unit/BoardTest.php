<?php

namespace Test\Unit;

use App\Game\Board;
use App\Game\Player;
use PHPUnit\Framework\TestCase;
use App\Contracts\BoardInterface;

class BoardTest extends TestCase
{
	/**
	 * @var BoardInterface $board
	 */
	private $board;

	public function setUp(): void
	{
		$this->board = new Board(
			new Player()
		);
	}

	public function testShouldHaveCorrectCountOfPlayerWhenAddPlayer()
    {
        $this->board->addNewPlayer('toto');
        $this->board->addNewPlayer('tata');

		self::assertEquals(2, $this->board->howManyPlayers());
	}

	public function testBoardIterationWithManyPlayers()
	{
		$this->board->addNewPlayer("Chet");
		$this->board->addNewPlayer("Pat");
		$this->board->addNewPlayer("Sue");

		$this->board->nextPlayerTurn();
		$this->board->nextPlayerTurn();
		$this->board->nextPlayerTurn();
		$this->board->nextPlayerTurn();

		self::assertEquals('Pat', (string)$this->board->getCurrentPlayer());
	}
}
