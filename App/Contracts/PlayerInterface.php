<?php

namespace App\Contracts;

interface PlayerInterface
{
	public function __toString();

	/**
	 * "Initialize" a player
	 *
	 * @param string $name
	 * 
	 * @return PlayerInterface
	 */
	public function initialize(string $name): PlayerInterface;

	/**
	 * Toss a coin to the player
	 * 
	 * @return void
	 */
	public function earnACoin(): void;

	/**
	 * Return how many coins player have
	 *
	 * @return int
	 */
	public function howManyCoins(): int;

	/**
	 * Move the player to his next place
	 *
	 * @param int $rolldice
	 * 
	 * @return void
	 */
	public function move(int $rolldice): void;

	/**
	 * Get the current place of the player
	 *
	 * @return integer
	 */
	public function getCurrentPlace(): int;
}