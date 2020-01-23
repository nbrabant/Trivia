<?php

namespace App\Deck;

use App\Contracts\QuestionInterface;

class Question implements QuestionInterface
{
	private $question;

	public function __toString() 
	{
		return $this->question;
	}

	/**
	 * Construct categories question deck
	 */
	public function __construct(string $question)
	{
		$this->question = $question;
	}
}
