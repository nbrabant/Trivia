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
}
