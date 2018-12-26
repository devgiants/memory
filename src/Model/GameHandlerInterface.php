<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/12/18
 * Time: 16:19
 */

namespace App\Model;


use App\Entity\Game;
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
     * @param UuidInterface $uuid
     * @param array $gameData
     *
     * @return Game
     */
    public function update(UuidInterface $uuid, array $gameData) : Game;
}