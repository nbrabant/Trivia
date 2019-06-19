<?php

use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    private $instance;

    protected function setUp(): void
    {
        $this->instance = new Player('Toto');
    }

    /**
     * @test
     */
    public function itShouldReturnThatPlayerNotWinTheGame()
    {
        $this->assertTrue($this->instance->hasNotWinGame());
    }

    /**
     * @test
     */
    public function itShouldReturnThatPlayerWinTheGame()
    {
        $this->instance->incrementPurses();
        $this->instance->incrementPurses();
        $this->instance->incrementPurses();
        $this->instance->incrementPurses();
        $this->instance->incrementPurses();
        $this->instance->incrementPurses();
        $this->assertFalse($this->instance->hasNotWinGame());
    }
}