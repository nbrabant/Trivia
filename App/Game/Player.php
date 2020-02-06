<?php

namespace App\Game;

use App\Contracts\PlayerInterface;

class Player implements PlayerInterface
{
	/**
	 * @var string $name
	 */
	private $name;

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
}
