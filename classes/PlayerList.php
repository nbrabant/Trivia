<?php

class PlayerList implements PlayerListContract
{
    private $players;

    public function __construct($players)
    {
        foreach ($players as $player) {
            $this->addPlayer($player);
        }
    }

    private function addPlayer($playerName)
    {
        array_push($this->players, [
            'name' => $playerName,
            'places' => [],
            'purses' => [],
            'inPenaltyBox' => false,
        ]);

        Console::writeLine($playerName . " was added");
        Console::writeLine("They are player number " . $this->howManyPlayers());
        return true;
    }

    public function howManyPlayers()
    {
        return count($this->players);
    }

    private function movePlayer($roll)
    {
//        $this->setCurrentPosition($this->getCurrentPosition() + $roll);
//        if ($this->getCurrentPosition() >= self::NB_CELLS) {
//            $this->setCurrentPosition($this->getCurrentPosition() - self::NB_CELLS);
//        }
    }
}