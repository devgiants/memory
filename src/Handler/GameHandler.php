<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/12/18
 * Time: 16:18
 */

namespace App\Handler;

use App\Model\CardFlusherInterface;
use App\Model\GameHandlerInterface;

class GameHandler implements GameHandlerInterface
{
    /**
     * @var CardFlusherInterface $cardsFlusher
     */
    protected $cardsFlusher;

    /**
     * GameHandler constructor.
     *
     * @param CardFlusherInterface $cardsFlusher
     */
    public function __construct(CardFlusherInterface $cardsFlusher)
    {
        $this->cardsFlusher = $cardsFlusher;
    }

    /**
     * @return CardFlusherInterface
     */
    public function getCardsFlusher(): CardFlusherInterface
    {
        return $this->cardsFlusher;
    }
}