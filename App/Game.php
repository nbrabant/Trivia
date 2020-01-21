<?php

namespace App;

function echoln($string) {
  echo $string."\n";
}

class Game 
{
	const CATEGORY_POP = "Pop";
	const CATEGORY_SCIENCE = "Science";
	const CATEGORY_SPORT = "Sports";
	const CATEGORY_ROCK = "Rock";

    public $players = array();
    public $places = array(0);
    public $purses = array(0);
    public $inPenaltyBox = array(0);

    private $popQuestions = array();
    private $scienceQuestions = array();
    private $sportsQuestions = array();
    private $rockQuestions = array();

    public $currentPlayer = 0;
    public $isGettingOutOfPenaltyBox;

	public function  __construct()
	{
        for ($i = 0; $i < 50; $i++) {
			array_push($this->popQuestions, $this->createQuestion(self::CATEGORY_POP, $i));
			array_push($this->scienceQuestions, $this->createQuestion(self::CATEGORY_SCIENCE, $i));
			array_push($this->sportsQuestions, $this->createQuestion(self::CATEGORY_SPORT, $i));
			array_push($this->rockQuestions, $this->createQuestion(self::CATEGORY_ROCK, $i));
    	}
    }

	/**
	 * Create and return question
	 *
	 * @param string $type
	 * @param int $index
	 * @return string
	 */
	private function createQuestion(string $type, int $index): string
	{
		return $type . " Question " . $index;
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

	    echoln($playerName . " was added");
	    echoln("They are player number " . count($this->players));
		return true;
	}

	private function howManyPlayers() 
	{
		return count($this->players);
	}

	public function roll($roll) 
	{
		echoln($this->players[$this->currentPlayer] . " is the current player");
		echoln("They have rolled a " . $roll);

		if ($this->inPenaltyBox[$this->currentPlayer] && !$this->tryToGetOutOfPenaltyBox($roll)) {
			return;
		}

		$this->movePlayer($roll);
		echoln("The category is " . $this->currentCategory());
		$this->askQuestion();
	}

	private function askQuestion() 
	{
		if ($this->currentCategory() == self::CATEGORY_POP)
			echoln(array_shift($this->popQuestions));
		if ($this->currentCategory() == self::CATEGORY_SCIENCE)
			echoln(array_shift($this->scienceQuestions));
		if ($this->currentCategory() == self::CATEGORY_SPORT)
			echoln(array_shift($this->sportsQuestions));
		if ($this->currentCategory() == self::CATEGORY_ROCK)
			echoln(array_shift($this->rockQuestions));
	}

	private function currentCategory() 
	{
		if (in_array($this->places[$this->currentPlayer], [0, 4, 8])) {
			return self::CATEGORY_POP;
		}

		if (in_array($this->places[$this->currentPlayer], [1, 5, 9])) {
			return self::CATEGORY_SCIENCE;
		}

		if (in_array($this->places[$this->currentPlayer], [2, 6, 10])) {
			return self::CATEGORY_SPORT;
		}

		return self::CATEGORY_ROCK;
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
		echoln("Question was incorrectly answered");
		echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
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

		echoln($this->players[$this->currentPlayer]
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
			echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
			return true;
		}
		
		$this->isGettingOutOfPenaltyBox = false;
		echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
		return false;
	}

	/**
	 * Give a coin to the current player
	 *
	 * @return void
	 */
	private function giveCoinToPlayer(): void
	{
		echoln("Answer was correct!!!!");
		$this->purses[$this->currentPlayer]++;
		echoln($this->players[$this->currentPlayer]
				. " now has "
				.$this->purses[$this->currentPlayer]
				. " Gold Coins.");
	}
}
