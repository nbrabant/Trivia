<?php

namespace App\Game;

use App\Contracts\PlayerInterface;

class Player implements PlayerInterface
{
	/**
	 * @var string $name
	 */
	private $name;
	/**
	 * @var integer $coins
	 */
	private $coins = 0;
	/**
	 * @var integer $place
	 */
	private $place = 0;
	/**
	 * @var boolean $inPenaltyBox
	 */
	private $inPenaltyBox = false;

	public function __toString()
	{
		return $this->name;
	}

	public function __construct(string $name = null)
	{
		$this->name = $name;
	}

	/**
	 * "Initialize" a player
	 *
	 * @param string $name
	 * 
	 * @return PlayerInterface
	 */
	public function initialize(string $name): PlayerInterface
	{
		return new self($name);
	}

	/**
	 * Toss a coin to the player
	 * 
	 * @return void
	 */
	public function earnACoin(): void
	{
		$this->coins++;

		//@FIXME : emit that the current player win here
	}

	/**
	 * Return how many coins player have
	 *
	 * @return int
	 */
	public function howManyCoins(): int
	{
		return $this->coins;
	}

	/**
	 * Move the player to his next place
	 *
	 * @param int $rolldice
	 * 
	 * @return void
	 */
	public function move(int $rolldice): void
	{
		$this->place = $this->place + $rolldice;

		if ($this->place > 11) {
			$this->place = $this->place - 12;
		}
	}

	/**
	 * Get the current place of the player
	 *
	 * @return integer
	 */
	public function getCurrentPlace(): int
	{
		return $this->place;
	}

	/**
	 * Move the player in penalty box
	 *
	 * @return void
	 */
	public function goToPenaltyBox(): void
	{
		$this->inPenaltyBox = true;
	}

	/**
	 * Check if player is in penalty box
	 *
	 * @return boolean
	 */
	public function isInPenaltyBox(): bool
	{
		return $this->inPenaltyBox;
	}
}
