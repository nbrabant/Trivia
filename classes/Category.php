<?php

class Category
{
    const POP = ['category' => 'Pop', 'places' => [0, 4, 8]];
    const SCIENCE = ['category' => 'Science', 'places' => [1, 5, 9]];
    const SPORTS = ['category' => 'Sports', 'places' => [2, 6, 10]];
    const ROCK = ['category' => 'Rock', 'places' => [3, 7, 11]];

    private $popQuestions = array();
    private $scienceQuestions = array();
    private $sportsQuestions = array();
    private $rockQuestions = array();

    public static function initialize()
    {
        $instance =  new self();
        return $instance->initializeQuestions();
    }

    public function getCategoryFromPosition($position)
    {
        if (in_array($position, self::POP['places'])) {
            return self::POP['category'];
        } elseif (in_array($position, self::SCIENCE['places'])) {
            return self::SCIENCE['category'];
        } elseif (in_array($position, self::SPORTS['places'])) {
            return self::SPORTS['category'];
        } elseif (in_array($position, self::ROCK['places'])) {
            return self::ROCK['category'];
        } else {
            throw new \Exception('inconnu');
        }
    }

    public function getQuestion($category)
    {
        return array_shift($this->{strtolower($category) . 'Questions'});
    }

    private function initializeQuestions()
    {
        array_map(function ($category) {
            $this->{strtolower($category) . 'Questions'} = $this->createQuestions($category);
        }, $this->getCategories());

        return $this;
    }

    private function createQuestions($category)
    {
        return array_map(function ($index) use($category) {
            return $category . " Category " . $index;
        }, range(1, 50));
    }

    private function getCategories()
    {
        return [
            self::POP['category'],
            self::SCIENCE['category'],
            self::SPORTS['category'],
            self::ROCK['category'],
        ];
    }
}