<?php
function echoln($string)
{
    echo $string . "\n";
}

class Game
{
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

    public function __construct()
    {
        for ($i = 0; $i < 50; $i++) {
            array_push($this->popQuestions, "Pop Question " . $i);
            array_push($this->scienceQuestions, ("Science Question " . $i));
            array_push($this->sportsQuestions, ("Sports Question " . $i));
            array_push($this->rockQuestions, ("Rock Question " . $i));
        }
    }

    public function add($playerName)
    {
        array_push($this->players, $playerName);
        $this->places[$this->howManyPlayers()] = 0;
        $this->purses[$this->howManyPlayers()] = 0;
        $this->inPenaltyBox[$this->howManyPlayers()] = false;

        echoln($playerName . " was added");
        echoln("They are player number " . $this->howManyPlayers());
        return true;
    }

    public function roll($roll)
    {
        echoln($this->players[$this->currentPlayer] . " is the current player");
        echoln("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer] && !$this->isPlayerGoOutOfPenaltyBox($roll)) {
            return;
        }

        $this->movePlayer($roll);
        echoln("The category is " . $this->currentCategory());
        $this->askQuestion();
    }

    /**
     * Operate actions when current player give a good answer and go to next turn
     *
     * @return bool
     */
    public function wasCorrectlyAnswered(): bool
    {
        if ($this->inPenaltyBox[$this->currentPlayer] &&
            !$this->isGettingOutOfPenaltyBox) {
            $this->changePlayer();
            return true;
        }

        $this->playerEarnGoldCoin();

        $winner = $this->didPlayerWin();
        $this->changePlayer();

        return $winner;
    }

    /**
     * Place current player in penalty box and go to next turn
     *
     * @return bool
     */
    public function wrongAnswer(): bool
    {
        echoln("Question was incorrectly answered");
        echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->changePlayer();
        return true;
    }

    private function howManyPlayers()
    {
        return count($this->players);
    }

    /**
     * Return if current player don't win the game
     *
     * @return bool
     */
    private function didPlayerWin(): bool
    {
        return !($this->purses[$this->currentPlayer] == 6);
    }

    /**
     * Change the player
     */
    private function changePlayer(): void
    {
        $this->currentPlayer++;
        if ($this->currentPlayer == $this->howManyPlayers()) $this->currentPlayer = 0;
    }

    /**
     * Move the current player
     *
     * @param $roll
     */
    private function movePlayer($roll): void
    {
        $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
        if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

        echoln($this->players[$this->currentPlayer]
            . "'s new location is "
            . $this->places[$this->currentPlayer]);
    }

    /**
     * Give one coin to current player
     */
    private function playerEarnGoldCoin(): void
    {
        echoln("Answer was correct!!!!");
        $this->purses[$this->currentPlayer]++;
        echoln($this->players[$this->currentPlayer]
            . " now has "
            . $this->purses[$this->currentPlayer]
            . " Gold Coins.");
    }

    /**
     * Check and return if current player get out of penalty box
     *
     * @param $roll
     *
     * @return bool
     */
    public function isPlayerGoOutOfPenaltyBox($roll): bool
    {
        if ($roll % 2 != 0) {
            echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
            $this->isGettingOutOfPenaltyBox = true;
            return true;
        }

        echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
        $this->isGettingOutOfPenaltyBox = false;
        return false;
    }

    private function askQuestion()
    {
        if ($this->currentCategory() == "Pop")
            echoln(array_shift($this->popQuestions));
        if ($this->currentCategory() == "Science")
            echoln(array_shift($this->scienceQuestions));
        if ($this->currentCategory() == "Sports")
            echoln(array_shift($this->sportsQuestions));
        if ($this->currentCategory() == "Rock")
            echoln(array_shift($this->rockQuestions));
    }

    private function currentCategory()
    {
        if ($this->places[$this->currentPlayer] == 0) return "Pop";
        if ($this->places[$this->currentPlayer] == 4) return "Pop";
        if ($this->places[$this->currentPlayer] == 8) return "Pop";
        if ($this->places[$this->currentPlayer] == 1) return "Science";
        if ($this->places[$this->currentPlayer] == 5) return "Science";
        if ($this->places[$this->currentPlayer] == 9) return "Science";
        if ($this->places[$this->currentPlayer] == 2) return "Sports";
        if ($this->places[$this->currentPlayer] == 6) return "Sports";
        if ($this->places[$this->currentPlayer] == 10) return "Sports";
        return "Rock";
    }

    private function isPlayable()
    {
        return ($this->howManyPlayers() >= 2);
    }
}
