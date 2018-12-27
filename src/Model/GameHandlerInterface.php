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
use Ramsey\Uuid\UuidInterface;

interface GameHandlerInterface
{
    /**
     * @return CardFlusherInterface
     */
    public function getCardsFlusher(): CardFlusherInterface;

    /**
     * @return Game
     */
    public function create(): Game;

    /**
     * @param Game $game
     * @param string $serializedGameData
     *
     * @return Game
     * @throws EntityNotFoundException
     */
    public function update(Game $game, string $serializedGameData): Game;

    /**
     * @return Game[]|array|object[]
     */
    public function getAllGames();

    /**
     * @param Game $game
     *
     */
    public function handleLongTermStatus(Game $game);
}