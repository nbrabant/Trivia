<?php


interface PlayerListContract
{
    public function howManyPlayers();

    public function nextPlayerTurn();

    public function getCurrentPlayer(): PlayerContract;

}