<?php

namespace App\Contracts;

use App\Contracts\CategoryInterface;

interface QuestionsDeckInterface 
{
	/**
	 * Get question from category
	 *
	 * @param integer $gameZone
	 * @return string
	 */
	public function getQuestionFromCategory(int $gameZone): string;

	/**
	 * Get category from his identifier
	 *
	 * @param integer $gameZone
	 * @return CategoryInterface
	 */
	public function getCategory(int $gameZone): CategoryInterface;

}