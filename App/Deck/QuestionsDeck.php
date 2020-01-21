<?php

namespace App\Deck;

use App\Contracts\QuestionsDeckInterface;

class QuestionsDeck implements QuestionsDeckInterface
{
	private $popQuestions = array();
    private $scienceQuestions = array();
    private $sportsQuestions = array();
    private $rockQuestions = array();

	/**
	 * Build deck with question for categories
	 *
	 * @return QuestionsDeckInterface
	 */
	public function buildDeck(): QuestionsDeckInterface
	{
		for ($i = 0; $i < 50; $i++) {
			array_push($this->popQuestions, $this->createQuestion(QuestionsDeckInterface::CATEGORY_POP, $i));
			array_push($this->scienceQuestions, $this->createQuestion(QuestionsDeckInterface::CATEGORY_SCIENCE, $i));
			array_push($this->sportsQuestions, $this->createQuestion(QuestionsDeckInterface::CATEGORY_SPORT, $i));
			array_push($this->rockQuestions, $this->createQuestion(QuestionsDeckInterface::CATEGORY_ROCK, $i));
		}

		return $this;
	}

	/**
	 * Get question from category
	 *
	 * @param integer $category
	 * @return string
	 */
	public function getQuestionFromCategory(int $category): string
	{
		if ($this->getCategory($category) == QuestionsDeckInterface::CATEGORY_POP)
			return array_shift($this->popQuestions);
		if ($this->getCategory($category) == QuestionsDeckInterface::CATEGORY_SCIENCE)
			return array_shift($this->scienceQuestions);
		if ($this->getCategory($category) == QuestionsDeckInterface::CATEGORY_SPORT)
			return array_shift($this->sportsQuestions);
		if ($this->getCategory($category) == QuestionsDeckInterface::CATEGORY_ROCK)
			return array_shift($this->rockQuestions);
	}

	/**
	 * Get category from his identifier
	 *
	 * @param integer $category
	 * @return string
	 */
	public function getCategory(int $category): string 
	{
		if (in_array($category, [0, 4, 8])) {
			return self::CATEGORY_POP;
		}

		if (in_array($category, [1, 5, 9])) {
			return self::CATEGORY_SCIENCE;
		}

		if (in_array($category, [2, 6, 10])) {
			return self::CATEGORY_SPORT;
		}

		return self::CATEGORY_ROCK;
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
