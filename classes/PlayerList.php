<?php

class PlayerList implements PlayerListContract
{
    private $players = array();

    private $currentPlayer = 0;

    public function __construct($players)
    {
        foreach ($players as $player) {
            $this->addPlayer($player);
        }
    }

    private function addPlayer($playerName)
    {
        array_push($this->players, new Player($playerName));

        Console::writeLine($playerName . " was added");
        Console::writeLine("They are player number " . $this->howManyPlayers());
        return true;
    }

    public function howManyPlayers()
    {
        return count($this->players);
    }

    public function nextPlayerTurn()
    {
        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
    }

    /**
     * @return PlayerContract $player
     */
    public function getCurrentPlayer(): PlayerContract
    {
        return $this->players[$this->currentPlayer];
    }
}