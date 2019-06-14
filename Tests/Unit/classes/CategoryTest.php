<?php

use \PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    private $instance;

    protected function setUp(): void
    {
        $this->instance = new QuestionDeck(50);
    }

    /**
     * @test
     *
     * @param int $position
     * @param String $category
     *
     * @dataProvider positionProvider
     */
    public function itShouldReturnCategoryFromPosition($position, $category)
    {
        $this->instance->getCategoryFromPosition($position);

        $this->assertEquals($category, $this->instance->getCategoryFromPosition($position));
    }

    /**
     * @test
     *
     * @param String $category
     *
     * @dataProvider categoriesProvider
     */
    public function itShouldReturnQuestion($category)
    {
        $question = $this->instance->getQuestion($category);

        $this->assertEquals($category . ' QuestionDeck 1', $question);

        $question = $this->instance->getQuestion($category);

        $this->assertEquals($category . ' QuestionDeck 2', $question);
    }

    public function positionProvider()
    {
        return [
            [0, 'Pop'],
            [1, 'Science'],
            [2, 'Sports'],
            [3, 'Rock'],
        ];
    }

    public function categoriesProvider()
    {
        return [
            ['Pop'],
            ['Science'],
            ['Sports'],
            ['Rock'],
        ];
    }
}