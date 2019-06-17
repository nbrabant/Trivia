<?php

interface PlayerContract
{
    const NB_CELLS = 12;

    const CURRENT_PLAYER_MSG = "%s is the current player";
    const PURSE_MSG = "%s now has %s Gold Coins.";
    const LOCATION_MSG = "%s's new location is %s";
    const SEND_TO_PENALTY_MSG = "%s was sent to the penalty box";
    const GET_OUT_PENALTY_MSG = "%s is not getting out of the penalty box";

    public function incrementPurses(): void;

    public function move($roll): void;

    public function getPosition(): int;

    public function penalise(bool $penalised): void;

    public function isPenalised(): bool;

    public function hasNotWinGame(): bool;

    public function formatMessage(string $message): string;

}