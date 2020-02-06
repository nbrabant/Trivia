<?php 

namespace App\Game;

use App\Contracts\BoardInterface;
use App\Contracts\PlayerInterface;

class Board implements BoardInterface
{
	/**
	 * @var PlayerInterface $playerFactory
	 */
	private $playerFactory;
	/**
	 * @var integer $currentPlayer
	 */
	private $currentPlayer = 0;
	/**
	 * @var Player[] $player
	 */
	private $players = [];

	public function __construct(PlayerInterface $playerFactory) 
	{
		$this->playerFactory = $playerFactory;
	}

	/**
	 * Initialize and add new player to the board
	 *
	 * @param string $playerName
	 * 
	 * @return void
	 */
	public function addNewPlayer(string $playerName): void
	{
		array_push($this->players, $this->playerFactory->initialize($playerName));

		// @FIXME : send player add event here...
	}

	/**
	 * Return how many player there are on the board
	 *
	 * @return integer
	 */
	public function howManyPlayers(): int
	{
		return count($this->players);
	}

	/**
	 * Return current player index
	 *
	 * @return integer
	 */
	public function getCurrentPlayerIndex(): int
	{
		return $this->currentPlayer;
	}

	/**
	 * Return current player
	 *
	 * @return PlayerInterface
	 */
	public function getCurrentPlayer(): PlayerInterface
	{
		return $this->players[$this->currentPlayer];
	}

	/**
	 * Pass turn to next player
	 *
	 * @return void
	 */
	public function nextPlayerTurn(): void 
	{
		$this->currentPlayer++;
		
		if ($this->currentPlayer == $this->howManyPlayers()) {
			$this->currentPlayer = 0;
		}
	}

}
