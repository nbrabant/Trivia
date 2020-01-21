<?php

namespace App\Contracts;

interface QuestionsDeckInterface 
{
	const CATEGORY_POP = "Pop";
	const CATEGORY_SCIENCE = "Science";
	const CATEGORY_SPORT = "Sports";
	const CATEGORY_ROCK = "Rock";

	/**
	 * Build deck with question for categories
	 *
	 * @return QuestionsDeckInterface
	 */
	public function buildDeck(): QuestionsDeckInterface;

	/**
	 * Get question from category
	 *
	 * @param integer $category
	 * @return string
	 */
	public function getQuestionFromCategory(int $category): string;

	/**
	 * Get category from his identifier
	 *
	 * @param integer $category
	 * @return string
	 */
	public function getCategory(int $category): string;

}