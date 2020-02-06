<?php

namespace App;

use App\Contracts\QuestionsDeckInterface;
use App\Contracts\BoardInterface;
use Psr\Log\LoggerInterface;

class Game 
{
	public $players = array();
    public $places = array(0);
    public $purses = array(0);
    public $inPenaltyBox = array(0);

    public $currentPlayer = 0;
	public $isGettingOutOfPenaltyBox;
	
	/**
	 * @var BoardInterface $board
	 */
	private $board;
	/**
	 * @var QuestionsDeckInterface $questionsDeck
	 */
	private $questionsDeck;
	/**
	 * @var Psr\Log\LoggerInterface $logger
	 */
	private $logger;

	public function  __construct(
		BoardInterface $board,
		QuestionsDeckInterface $questionsDeck,
		LoggerInterface $logger
	) { 
		$this->board = $board;
		// FIXME : Question deck may be a composant of the game board...
		$this->questionsDeck = $questionsDeck;
		$this->logger = $logger;
    }

	private function isPlayable(): boolean
	{
		return ($this->board->howManyPlayers() >= 2);
	}

	public function add($playerName) 
	{
		$this->board->addNewPlayer($playerName);
	   	// array_push($this->players, $playerName);
	   	$this->places[$this->board->howManyPlayers()] = 0;
	   	$this->purses[$this->board->howManyPlayers()] = 0;
	   	$this->inPenaltyBox[$this->board->howManyPlayers()] = false;

		// @FIXME : Log may be just event sended...
	    $this->logger->info($playerName . " was added");
		$this->logger->info("They are player number " . $this->board->howManyPlayers());
		return true;
	}

	public function roll($roll) 
	{
		$this->logger->info($this->board->getCurrentPlayer() . " is the current player");
		$this->logger->info("They have rolled a " . $roll);

		if ($this->inPenaltyBox[$this->board->getCurrentPlayerIndex()] && !$this->tryToGetOutOfPenaltyBox($roll)) {
			return;
		}

		$this->movePlayer($roll);

		$this->askQuestion();
	}

	private function askQuestion() 
	{
		$this->logger->info("The category is " . $this->questionsDeck->getCategory(
			$this->places[$this->board->getCurrentPlayerIndex()]
		));
		$this->logger->info(
			$this->questionsDeck->getQuestionFromCategory(
				$this->places[$this->board->getCurrentPlayerIndex()]
			)
		);
	}

	public function wasCorrectlyAnswered(): bool
	{
		if ($this->inPenaltyBox[$this->board->getCurrentPlayerIndex()] && !$this->isGettingOutOfPenaltyBox) {
			$this->board->nextPlayerTurn();
			return false;
		}

		$this->giveCoinToPlayer();

		$winner = $this->didPlayerWin();
		$this->board->nextPlayerTurn();

		return $winner;
	}

	public function wrongAnswer(): bool
	{
		$this->logger->info("Question was incorrectly answered");
		$this->logger->info($this->board->getCurrentPlayer() . " was sent to the penalty box");
		$this->inPenaltyBox[$this->board->getCurrentPlayerIndex()] = true;

		$this->board->nextPlayerTurn();
		return false;
	}

	/**
	 * Check if current player earn enough coins to win 
	 *
	 * @return boolean
	 */
	private function didPlayerWin(): bool
	{
		return ($this->purses[$this->board->getCurrentPlayerIndex()] >= 6);
	}

	/**
	 * Move the current player with dice result
	 *
	 * @param int $roll
	 * @return void
	 */
	private function movePlayer(int $roll): void
	{
		$this->places[$this->board->getCurrentPlayerIndex()] = $this->places[$this->board->getCurrentPlayerIndex()] + $roll;
		if ($this->places[$this->board->getCurrentPlayerIndex()] > 11) $this->places[$this->board->getCurrentPlayerIndex()] = $this->places[$this->board->getCurrentPlayerIndex()] - 12;

		$this->logger->info($this->board->getCurrentPlayer() . 
			"'s new location is " . 
			$this->places[$this->board->getCurrentPlayerIndex()]);
	}

	/**
	 * Try to get current player out of penalty box
	 *
	 * @param integer $roll
	 * @return boolean
	 */
	private function tryToGetOutOfPenaltyBox(int $roll): bool
	{
		if ($roll % 2 != 0) {
			$this->isGettingOutOfPenaltyBox = true;
			$this->logger->info($this->board->getCurrentPlayer() . " is getting out of the penalty box");
			return true;
		}
		
		$this->isGettingOutOfPenaltyBox = false;
		$this->logger->info($this->board->getCurrentPlayer() . " is not getting out of the penalty box");
		return false;
	}

	/**
	 * Give a coin to the current player
	 *
	 * @return void
	 */
	private function giveCoinToPlayer(): void
	{
		$this->logger->info("Answer was correct!!!!");
		$this->purses[$this->board->getCurrentPlayerIndex()]++;
		$this->logger->info($this->board->getCurrentPlayer()
				. " now has "
				.$this->purses[$this->board->getCurrentPlayerIndex()]
				. " Gold Coins.");
	}
}
