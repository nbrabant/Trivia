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
	 * @var array $drawableQuestions
	 */
	private $drawableQuestions = array();
	/**
	 * @var array $askedQuestions
	 */
	private $askedQuestions = array();

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
			array_push($this->drawableQuestions, $this->createQuestion($this->categoryName, $i));
		}
	}

	/**
	 * Draw and return a question from the category deck
	 *
	 * @return string
	 */
	public function drawQuestion(): string
	{
		$this->shuffleQuestionsIfItNeeded();

		$question = array_shift($this->drawableQuestions);

		$this->askedQuestions[] = $question;

		return $question;
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

	/**
	 * Shuffle asked question in drawable questions
	 *
	 * @return void
	 */
	private function shuffleQuestionsIfItNeeded()
	{
		if (!empty($this->drawableQuestions)) {
			return;
		}

		$this->drawableQuestions = $this->askedQuestions;
		shuffle($this->drawableQuestions);

		$this->askedQuestions = [];
	}
}
