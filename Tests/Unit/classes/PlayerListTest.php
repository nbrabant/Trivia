<?php

use PHPUnit\Framework\TestCase;

class PlayerListTest extends TestCase
{
    const PLAYERS_NAMES = [
        self::FIRST_PLAYER,
        self::SECOND_PLAYER,
        self::THIRD_PLAYER,
    ];
    const FIRST_PLAYER = 'toto';
    const SECOND_PLAYER = 'tata';
    const THIRD_PLAYER = 'titi';

    private $instance;

    protected function setUp(): void
    {
        $this->instance = new PlayerList(self::PLAYERS_NAMES);
    }

    /**
     * @test
     */
    public function itShouldHaveCorrectNumberOfPlayers()
    {
        $this->assertEquals(3, $this->instance->howManyPlayers());
    }

    /**
     * @test
     */
    public function itShouldChangeCurrentPlayer()
    {
        $this->assertEquals(self::FIRST_PLAYER, (string)$this->instance->getCurrentPlayer());
        $this->instance->nextPlayerTurn();
        $this->assertEquals(self::SECOND_PLAYER, (string)$this->instance->getCurrentPlayer());
    }

    /**
     * @test
     */
    public function itShouldReturnToFirstPlayerWhenItCallNextOnListBottom()
    {
        $this->assertEquals(self::FIRST_PLAYER, (string)$this->instance->getCurrentPlayer());
        $this->instance->nextPlayerTurn();
        $this->instance->nextPlayerTurn();
        $this->instance->nextPlayerTurn();
        $this->assertEquals(self::FIRST_PLAYER, (string)$this->instance->getCurrentPlayer());
    }
}