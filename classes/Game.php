<?php

class Game
{
    const NB_CELLS = 12;

    private $players;
    private $places;
    private $purses;
    private $inPenaltyBox;

    private $currentPlayer = 0;
    private $isGettingOutOfPenaltyBox;

    private $categories;

    public function __construct(CategoryContract $categories)
    {
        $this->players = array();
        $this->places = array(0);
        $this->purses = array(0);
        $this->inPenaltyBox = array(0);

        $this->categories = $categories;
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

        Console::writeLine($playerName . " was added");
        Console::writeLine("They are player number " . count($this->players));
        return true;
    }

    private function howManyPlayers()
    {
        return count($this->players);
    }

    public function roll($roll)
    {
        Console::writeLine($this->getCurrentPlayer() . " is the current player");
        Console::writeLine("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($roll % 2 != 0) {
                $this->isGettingOutOfPenaltyBox = true;

                Console::writeLine($this->getCurrentPlayer() . " is getting out of the penalty box");
                $this->movePlayer($roll);

                Console::writeLine($this->getCurrentPlayer()
                    . "'s new location is "
                    . $this->getCurrentPosition());
                Console::writeLine("The category is " . $this->currentCategory());
                $this->askQuestion();
            } else {
                Console::writeLine($this->getCurrentPlayer() . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }
        } else {
            $this->movePlayer($roll);

            Console::writeLine($this->getCurrentPlayer()
                . "'s new location is "
                . $this->getCurrentPosition());
            Console::writeLine("The category is " . $this->currentCategory());
            $this->askQuestion();
        }
    }

    private function movePlayer($roll)
    {
        $this->setCurrentPosition($this->getCurrentPosition() + $roll);
        if ($this->getCurrentPosition() >= self::NB_CELLS) {
            $this->setCurrentPosition($this->getCurrentPosition() - self::NB_CELLS);
        }
    }

    private function askQuestion()
    {
        Console::writeLine($this->categories->getQuestion($this->currentCategory()));
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
                Console::writeLine("Answer was correct!!!!");
                $this->purses[$this->currentPlayer]++;
                Console::writeLine($this->getCurrentPlayer()
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

            Console::writeLine("Answer was corrent!!!!");
            $this->purses[$this->currentPlayer]++;
            Console::writeLine($this->getCurrentPlayer()
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
        Console::writeLine("Category was incorrectly answered");
        Console::writeLine($this->getCurrentPlayer() . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
        return true;
    }


    private function didPlayerWin()
    {
        return !($this->purses[$this->currentPlayer] == 6);
    }

}
