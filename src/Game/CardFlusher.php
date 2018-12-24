<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 22:45
 */

namespace App\Game;

use App\Model\CardFlusherInterface;
use Memory\Card;

/**
 * Class CardFlusher
 *
 * @package App\Game
 */
class CardFlusher implements CardFlusherInterface
{

    /**
     * @var array $initialCards cards initial set
     */
    protected $initialCards;

    /**
     * CardFlusher init.
     *
     * @param array $initialCards cards initial set
     */
    public function init(array $initialCards)
    {
        foreach ($initialCards as $initialCard) {

            // Add 2 cards in deck
            $this->initialCards[] = new Card($initialCard);
            $this->initialCards[] = new Card($initialCard);
        }
    }

    /**
     * Shuffle the cards and get the result
     *
     * @return array[Card]
     */
    public function shuffle(): array
    {
        shuffle($this->initialCards);
        return $this->initialCards;
    }
}