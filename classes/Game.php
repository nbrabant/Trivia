<?php

class Game
{
    private $players;
    private $places;
    private $purses;
    private $inPenaltyBox;

    private $currentPlayer = 0;
    private $isGettingOutOfPenaltyBox;

    private $categories;

    public function __construct()
    {
        $this->players = array();
        $this->places = array(0);
        $this->purses = array(0);
        $this->inPenaltyBox = array(0);

        $this->categories = Category::initialize();
    }

    function isPlayable()
    {
        return ($this->howManyPlayers() >= 2);
    }

    public function addPlayer($playerName)
    {
        array_push($this->players, $playerName);
        $this->places[$this->howManyPlayers()] = 0;
        $this->purses[$this->howManyPlayers()] = 0;
        $this->inPenaltyBox[$this->howManyPlayers()] = false;

        $this->writeLine($playerName . " was added");
        $this->writeLine("They are player number " . count($this->players));
        return true;
    }

    private function howManyPlayers()
    {
        return count($this->players);
    }

    public function roll($roll)
    {
        $this->writeLine($this->getCurrentPlayer() . " is the current player");
        $this->writeLine("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($roll % 2 != 0) {
                $this->isGettingOutOfPenaltyBox = true;

                $this->writeLine($this->getCurrentPlayer() . " is getting out of the penalty box");
                $this->setCurrentPosition($this->getCurrentPosition() + $roll);
                if ($this->getCurrentPosition() > 11) $this->setCurrentPosition($this->getCurrentPosition() - 12);

                $this->writeLine($this->getCurrentPlayer()
                    . "'s new location is "
                    . $this->getCurrentPosition());
                $this->writeLine("The category is " . $this->currentCategory());
                $this->askQuestion();
            } else {
                $this->writeLine($this->getCurrentPlayer() . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }

        } else {

            $this->setCurrentPosition($this->getCurrentPosition() + $roll);
            if ($this->getCurrentPosition() > 11) $this->setCurrentPosition($this->getCurrentPosition() - 12);

            $this->writeLine($this->getCurrentPlayer()
                . "'s new location is "
                . $this->getCurrentPosition());
            $this->writeLine("The category is " . $this->currentCategory());
            $this->askQuestion();
        }

    }

    private function askQuestion()
    {
        $this->writeLine($this->categories->getQuestion($this->currentCategory()));
    }

    private function currentCategory()
    {
        return $this->categories->getCategoryFromPosition($this->getCurrentPosition());
    }

    private function getCurrentPosition()
    {
        return $this->places[$this->currentPlayer];
    }

    private function setCurrentPosition($position)
    {
        $this->places[$this->currentPlayer] = $position;
    }

    private function getCurrentPlayer()
    {
        return $this->players[$this->currentPlayer];
    }

    public function wasCorrectlyAnswered()
    {
        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($this->isGettingOutOfPenaltyBox) {
                $this->writeLine("Answer was correct!!!!");
                $this->purses[$this->currentPlayer]++;
                $this->writeLine($this->getCurrentPlayer()
                    . " now has "
                    . $this->purses[$this->currentPlayer]
                    . " Gold Coins.");

                $winner = $this->didPlayerWin();
                $this->currentPlayer++;
                if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;

                return $winner;
            } else {
                $this->currentPlayer++;
                if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
                return true;
            }


        } else {

            $this->writeLine("Answer was corrent!!!!");
            $this->purses[$this->currentPlayer]++;
            $this->writeLine($this->getCurrentPlayer()
                . " now has "
                . $this->purses[$this->currentPlayer]
                . " Gold Coins.");

            $winner = $this->didPlayerWin();
            $this->currentPlayer++;
            if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;

            return $winner;
        }
    }

    public function wrongAnswer()
    {
        $this->writeLine("Category was incorrectly answered");
        $this->writeLine($this->getCurrentPlayer() . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
        return true;
    }


    private function didPlayerWin()
    {
        return !($this->purses[$this->currentPlayer] == 6);
    }

    private function writeLine($line)
    {
        echo $line . "\n";
    }
}
