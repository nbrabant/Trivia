<?php

namespace App\Contracts;

interface BoardInterface
{
	/**
	 * Initialize and add new player to the board
	 *
	 * @param string $playerName
	 * 
	 * @return BoardInterface
	 */
	public function addNewPlayer(string $playerName): void;

	/**
	 * Return how many player there are on the board
	 *
	 * @return integer
	 */
	public function howManyPlayers(): int;
	
	/**
	 * Return current player index
	 * @deprecated
	 *
	 * @return integer
	 */
	public function getCurrentPlayerIndex(): int;

	/**
	 * Return current player
	 *
	 * @return string
	 */
	public function getCurrentPlayer(): string;

	/**
	 * Pass turn to next player
	 *
	 * @return void
	 */
	public function nextPlayerTurn(): void;
}