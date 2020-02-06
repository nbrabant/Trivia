<?php

namespace Test\Unit;

use App\Game;
use App\Game\Board;
use App\Game\Player;
use App\Contracts\BoardInterface;
use App\Contracts\QuestionsDeckInterface;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Golden master for non regression acceptance
 */
class GoldenMaster extends TestCase
{
	/**
	 * @var Game $game
	 */
	private $game;

	public function setUp(): void
	{
        $this->game = new Game(
            new Board(
                new Player()
            ),
            $this->createMock(QuestionsDeckInterface::class),
            $this->createMock(LoggerInterface::class)
        );
	}

	public function testShouldInitializeANewPlayerWhenAddPlayer()
    {
        $this->game->add('toto');

        // assert player initialisation step
        self::assertEquals(0, $this->game->purses[0]);
        self::assertEquals(0, $this->game->places[0]);
	}
	
	public function testShouldPlaceActivePlayerToFiveWhenAFiveIsRolledOnDice()
    {
        $this->game->add('toto');
        $this->game->roll(5);

        self::assertEquals(5, $this->game->places[0]);
	}
	

	public function testShouldPlaceActivePlayerToZeroWhenTwelveIsRolled()
    {
        $this->game->add('toto');
        $this->game->roll(12);

        self::assertEquals(0, $this->game->places[0]);
    }

    public function testKeepInPenaltyBoxAPenalizedPlayerWhenPairIsRolled()
    {
        $this->game->add('toto');
        $this->game->inPenaltyBox[0] = true;
        $this->game->roll(6);

        self::assertFalse($this->game->isGettingOutOfPenaltyBox);
    }

    public function testShouldGetOutOfPenaltyBoxAPenalizedPlayerWhenImpairRolled()
    {
        $this->game->add('toto');
        $this->game->inPenaltyBox[0] = true;
        $this->game->roll(5);

        self::assertTrue($this->game->isGettingOutOfPenaltyBox);
    }

    public function testShouldNotEarnPointWhenPenalizedPlayerHasCorrectlyAnswered()
    {
        $this->game->add('toto');
        $this->game->inPenaltyBox[0] = true;
        $this->game->roll(6);
        $this->game->wasCorrectlyAnswered();

        self::assertEquals(0, $this->game->purses[0]);
    }

    public function testShouldEarnPointWhenOutOfPenaltyPlayerHasCorrectlyAnswered()
    {
        $this->game->add('toto');
        $this->game->inPenaltyBox[0] = true;
        $this->game->roll(5);
        $this->game->wasCorrectlyAnswered();

        self::assertEquals(1, $this->game->purses[0]);
    }

    public function testShouldNotWinTheGameForACorrectAnswerWhenPlayerHasNotEnoughtPoints()
    {
        $this->game->add('toto');
        $this->game->roll(5);

        self::assertFalse($this->game->wasCorrectlyAnswered());
    }

    public function testShouldWinTheGameForACorrectAnswerWhenPlayerHasEnoughPoints()
    {
        $this->game->add('toto');
        $this->game->purses[0] = 5;
        $this->game->roll(5);

        self::assertTrue($this->game->wasCorrectlyAnswered());
    }

    public function testSouldGoToThePenalityBoxWhenPlayerHasNotCorrectlyAnswered()
    {
        $this->game->add('toto');
        $this->game->roll(5);
        $this->game->wrongAnswer();

        self::assertTrue($this->game->inPenaltyBox[0]);
    }

    public function testGameIterationWithManyPlayers()
    {
        $this->game->add("Chet");
        $this->game->add("Pat");
        $this->game->add("Sue");

        // Chet turn
        $this->game->roll(1);
        $this->game->wrongAnswer();

        // Pat turn
        $this->game->roll(6);
        $this->game->wasCorrectlyAnswered();

        // Sue turn
        $this->game->roll(4);
        $this->game->wasCorrectlyAnswered();

        // Chet turn
        $this->game->roll(2);
        $this->game->wasCorrectlyAnswered();

        // Pat turn
        $this->game->roll(5);
        $this->game->wrongAnswer();

        // Sue turn
        $this->game->roll(3);
        $this->game->wasCorrectlyAnswered();

        // Chet turn
        $this->game->roll(3);
        $this->game->wasCorrectlyAnswered();

        // so, we check the game state here
        self::assertEquals([
            0 => 4,
            1 => 11,
            2 => 7,
            3 => 0,
        ],  $this->game->places);
        self::assertEquals([
            0 => 1,
            1 => 1,
            2 => 2,
            3 => 0,
        ],  $this->game->purses);
        self::assertEquals([
            0 => true,
            1 => true,
            2 => false,
            3 => false,
        ],  $this->game->inPenaltyBox);
    }
}
