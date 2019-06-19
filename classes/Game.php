<?php

class Game
{
    private $isGettingOutOfPenaltyBox;

    /**
     * @var QuestionDeckContract
     */
    private $questionDeck;
    /**
     * @var PlayerListContract
     */
    private $playerList;

    public function __construct(
        QuestionDeckContract $categories,
        PlayerListContract $playerList
    ) {
        $this->questionDeck = $categories;
        $this->playerList = $playerList;
    }

    function isPlayable()
    {
        return ($this->playerList->howManyPlayers() >= 2);
    }

    public function roll($roll)
    {
        Console::writeLine(
            $this->playerList->getCurrentPlayer()->formatMessage(PlayerContract::CURRENT_PLAYER_MSG)
        );
        Console::writeLine("They have rolled a " . $roll);

        if ($this->playerList->getCurrentPlayer()->isPenalised()) {
            if ($roll % 2 != 0) {
                $this->playerList->getCurrentPlayer()->penalise(false);

                Console::writeLine(
                    $this->playerList->getCurrentPlayer()->formatMessage(PlayerContract::GET_OUT_PENALTY_MSG)
                );
                $this->playerList->getCurrentPlayer()->move($roll);

                Console::writeLine(
                    $this->playerList->getCurrentPlayer()->formatMessage(PlayerContract::LOCATION_MSG)
                );
                Console::writeLine("The category is " . $this->currentCategory());
                $this->askQuestion();
            } else {
                Console::writeLine(
                    $this->playerList->getCurrentPlayer()->formatMessage(PlayerContract::GET_OUT_PENALTY_MSG)
                );
                $this->isGettingOutOfPenaltyBox = false;
            }
        } else {
            $this->playerList->getCurrentPlayer()->move($roll);

            Console::writeLine(
                $this->playerList->getCurrentPlayer()->formatMessage(PlayerContract::LOCATION_MSG)
            );
            Console::writeLine("The category is " . $this->currentCategory());
            $this->askQuestion();
        }
    }

    private function askQuestion()
    {
        Console::writeLine(
            $this->questionDeck->getQuestion($this->currentCategory())
        );
    }

    private function currentCategory()
    {
        return $this->questionDeck->getCategoryFromPosition(
            $this->playerList->getCurrentPlayer()->getPosition()
        );
    }

    public function wasCorrectlyAnswered()
    {
        if ($this->playerList->getCurrentPlayer()->isPenalised()) {
            if ($this->isGettingOutOfPenaltyBox) {
                Console::writeLine("Answer was correct!!!!");
                $this->playerList->getCurrentPlayer()->incrementPurses();
                Console::writeLine(
                    $this->playerList->getCurrentPlayer()->formatMessage(PlayerContract::PURSE_MSG)
                );

                $winner = $this->playerList->getCurrentPlayer()->hasNotWinGame();
                $this->playerList->nextPlayerTurn();

                return $winner;
            }

        } else {

            Console::writeLine("Answer was correct!!!!");
            $this->playerList->getCurrentPlayer()->incrementPurses();
            Console::writeLine(
                $this->playerList->getCurrentPlayer()->formatMessage(PlayerContract::PURSE_MSG)
            );

            $winner = $this->playerList->getCurrentPlayer()->hasNotWinGame();
            $this->playerList->nextPlayerTurn();

            return $winner;
        }

        $this->playerList->nextPlayerTurn();
        return true;
    }

    public function wrongAnswer()
    {
        Console::writeLine("QuestionDeck was incorrectly answered");
        Console::writeLine(
            $this->playerList->getCurrentPlayer()->formatMessage(PlayerContract::SEND_TO_PENALTY_MSG)
        );
        $this->playerList->getCurrentPlayer()->penalise(true);

        $this->playerList->nextPlayerTurn();
        return true;
    }

}
