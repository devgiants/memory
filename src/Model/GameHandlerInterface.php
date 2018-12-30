<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/12/18
 * Time: 16:19
 */

namespace App\Model;


use App\Entity\Game;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Interface GameHandlerInterface
 *
 * @package App\Model
 */
interface GameHandlerInterface
{
    /**
     * Get the card flusher object
     * @return CardFlusherInterface the card flusher object
     */
    public function getCardsFlusher(): CardFlusherInterface;

    /**
     * Get time to finish for handled games
     * @return int the time to finish
     */
    public function getTimeToFinish(): int;

    /**
     * Creates a new game
     * @return Game the created game
     * @throws \Exception throwed if game persists fails
     */
    public function create(): Game;

    /**
     * Update a game with given data
     * @param Game $game the game to update
     * @param string $serializedGameData serialized data for game update
     *
     * @return Game
     */
    public function update(Game $game, string $serializedGameData): Game;

    /**
     * Returns all games from database
     * @return Game[]|array|object[] the game ArrayCollection
     */
    public function getAllGames();

    /**
     * Change game status if first access player quit before end
     * @param Game $game the game concerned
     *
     * @throws \Exception if persist problem
     */
    public function handleLongTermStatus(Game $game);
}