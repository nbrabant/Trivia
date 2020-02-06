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
}