<?php

namespace App\Contracts;

interface CategoryInterface
{
	const POP = "Pop";
	const SCIENCE = "Science";
	const SPORT = "Sports";
	const ROCK = "Rock";

	public function __toString();

	/**
	 * Draw and return a question from the category deck
	 *
	 * @return string
	 */
	public function drawQuestion(): string;
}