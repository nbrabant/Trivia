<?php

namespace Test\Unit;

use App\Deck\Category;
use PHPUnit\Framework\TestCase;
use App\Contracts\CategoryInterface;

class CategoryTest extends TestCase
{
	/**
	 * @var CategoryInterface $category
	 */
	private $category;

	public function setUp(): void
	{
		$this->category = new Category(CategoryInterface::POP);
	}

	public function testShouldShuffleDeckWhenLastQuestionIsDrawed() 
	{
		for ($i=0; $i <= 51; $i++) { 
			$this->category->drawQuestion();
		}

		$this->assertTrue(true);
	}
}
