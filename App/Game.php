<?php

namespace App;

use App\Contracts\QuestionsDeckInterface;
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
	 * @var QuestionsDeckInterface $questionsDeck
	 */
	private $questionsDeck;
	/**
	 * @var Psr\Log\LoggerInterface $logger
	 */
	private $logger;

	public function  __construct(
		QuestionsDeckInterface $questionsDeck,
		LoggerInterface $logger
	) { 
		$this->questionsDeck = $questionsDeck->buildDeck();
		$this->logger = $logger;
    }

	private function isPlayable(): boolean
	{
		return ($this->howManyPlayers() >= 2);
	}

	public function add($playerName) 
	{
	   	array_push($this->players, $playerName);
	   	$this->places[$this->howManyPlayers()] = 0;
	   	$this->purses[$this->howManyPlayers()] = 0;
	   	$this->inPenaltyBox[$this->howManyPlayers()] = false;

	    $this->logger->info($playerName . " was added");
	    $this->logger->info("They are player number " . count($this->players));
		return true;
	}

	private function howManyPlayers() 
	{
		return count($this->players);
	}

	public function roll($roll) 
	{
		$this->logger->info($this->players[$this->currentPlayer] . " is the current player");
		$this->logger->info("They have rolled a " . $roll);

		if ($this->inPenaltyBox[$this->currentPlayer] && !$this->tryToGetOutOfPenaltyBox($roll)) {
			return;
		}

		$this->movePlayer($roll);

		$this->askQuestion();
	}

	private function askQuestion() 
	{
		$this->logger->info("The category is " . $this->questionsDeck->getCategory(
			$this->places[$this->currentPlayer]
		));
		$this->logger->info(
			$this->questionsDeck->getQuestionFromCategory(
				$this->places[$this->currentPlayer]
			)
		);
	}

	public function wasCorrectlyAnswered(): bool
	{
		if ($this->inPenaltyBox[$this->currentPlayer] && !$this->isGettingOutOfPenaltyBox) {
			$this->nextPlayerTurn();
			return false;
		}

		$this->giveCoinToPlayer();

		$winner = $this->didPlayerWin();
		$this->nextPlayerTurn();

		return $winner;
	}

	public function wrongAnswer(): bool
	{
		$this->logger->info("Question was incorrectly answered");
		$this->logger->info($this->players[$this->currentPlayer] . " was sent to the penalty box");
		$this->inPenaltyBox[$this->currentPlayer] = true;

		$this->nextPlayerTurn();
		return false;
	}

	/**
	 * Next player turn
	 *
	 * @return void
	 */
	private function nextPlayerTurn(): void
	{
		$this->currentPlayer++;
		if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
	}

	/**
	 * Check if current player earn enough coins to win 
	 *
	 * @return boolean
	 */
	private function didPlayerWin(): bool
	{
		return ($this->purses[$this->currentPlayer] >= 6);
	}

	/**
	 * Move the current player with dice result
	 *
	 * @param int $roll
	 * @return void
	 */
	private function movePlayer(int $roll): void
	{
		$this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
		if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

		$this->logger->info($this->players[$this->currentPlayer]
				. "'s new location is "
				.$this->places[$this->currentPlayer]);
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
			$this->logger->info($this->players[$this->currentPlayer] . " is getting out of the penalty box");
			return true;
		}
		
		$this->isGettingOutOfPenaltyBox = false;
		$this->logger->info($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
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
		$this->purses[$this->currentPlayer]++;
		$this->logger->info($this->players[$this->currentPlayer]
				. " now has "
				.$this->purses[$this->currentPlayer]
				. " Gold Coins.");
	}
}
