<?php

namespace App\Deck;

use App\Contracts\CategoryInterface;

class Category implements CategoryInterface
{
	/**
	 * @var string $categoryName
	 */
	private $categoryName;
	/**
	 * @var array $questions
	 */
	private $questions = array();

	public function __toString() 
	{
		return $this->categoryName;
	}

	/**
	 * Construct categories question deck
	 */
	public function __construct(string $categoryName)
	{
		$this->categoryName = $categoryName;
		
		for ($i = 0; $i < 50; $i++) {
			array_push($this->questions, $this->createQuestion($this->categoryName, $i));
		}
	}

	/**
	 * Draw and return a question from the category deck
	 *
	 * @return string
	 */
	public function drawQuestion(): string
	{
		return array_shift($this->questions);
	}

	/**
	 * Create and return question
	 *
	 * @param string $type
	 * @param int $index
	 * @return string
	 */
	private function createQuestion(string $type, int $index): string
	{
		return $type . " Question " . $index;
	}

}
