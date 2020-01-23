<?php

namespace App\Deck;

use App\Contracts\CategoryInterface;
use App\Deck\Question;

class Category implements CategoryInterface
{
	/**
	 * @var string $categoryName
	 */
	private $categoryName;
	/**
	 * @var Question[] $drawableQuestions
	 */
	private $drawableQuestions = [];
	/**
	 * @var Question[] $askedQuestions
	 */
	private $askedQuestions = [];

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
		
		$this->drawableQuestions = array_map(function($index) {
			return new Question($this->categoryName . " Question " . $index);
		}, range(0, 50));
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
