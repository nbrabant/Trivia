<?php

namespace App\Deck;

use App\Contracts\QuestionsDeckInterface;
use App\Contracts\CategoryInterface;

class QuestionsDeck implements QuestionsDeckInterface
{
	private $popQuestions;
    private $scienceQuestions;
    private $sportsQuestions;
    private $rockQuestions;

	public function __construct(
		Category $popQuestions,
		Category $scienceQuestions,
		Category $sportsQuestions,
		Category $rockQuestions
	) {
		$this->popQuestions = $popQuestions;
		$this->scienceQuestions = $scienceQuestions;
		$this->sportsQuestions = $sportsQuestions;
		$this->rockQuestions = $rockQuestions;	
	}

	/**
	 * Get question from game zone's category
	 *
	 * @param integer $gameZone
	 * @return string
	 */
	public function getQuestionFromCategory(int $gameZone): string
	{
		return $this->getCategory($gameZone)
			->drawQuestion();
	}

	/**
	 * Get category from his game zone
	 *
	 * @param integer $gameZone
	 * @return CategoryInterface
	 */
	public function getCategory(int $gameZone): CategoryInterface
	{
		if (in_array($gameZone, [0, 4, 8])) {
			return $this->popQuestions;
		}

		if (in_array($gameZone, [1, 5, 9])) {
			return $this->scienceQuestions;
		}

		if (in_array($gameZone, [2, 6, 10])) {
			return $this->sportsQuestions;
		}

		return $this->rockQuestions;
	}

}
