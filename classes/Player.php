<?php

class Player implements PlayerContract
{
    private $name;

    private $places = 0;

    private $purses = 0;

    private $inPenaltyBox = false;

    public function __toString(): string
    {
        return $this->name;
    }

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function incrementPurses(): void
    {
        $this->purses++;
    }

    public function move($roll): void
    {
        $this->places += $roll;
        if ($this->places >= self::NB_CELLS) {
            $this->places -= self::NB_CELLS;
        }
    }

    public function getPosition(): int
    {
        return $this->places;
    }

    public function penalise(bool $penalised): void
    {
        $this->inPenaltyBox = $penalised;
    }

    public function isPenalised(): bool
    {
        return $this->inPenaltyBox;
    }

    public function hasNotWinGame(): bool
    {
        return $this->purses !== 6;
    }

    public function formatMessage(string $message): string
    {
        if ($message == PlayerContract::PURSE_MSG) {
            return sprintf($message, $this->name, $this->purses);
        } elseif ($message == PlayerContract::LOCATION_MSG) {
            return sprintf($message, $this->name, $this->places);
        }

        return sprintf($message, $this->name);
    }
}