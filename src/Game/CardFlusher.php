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
 * This class brings necessary things to flush cards
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
     * @var array $shuffledCards when cards are shuffled
     */
    protected $shuffledCards;


    /**
     * CardFlusher constructor.
     *
     * @param array $availableCards the given available cards
     */
    public function __construct(array $availableCards)
    {
        $this->initialCards = $availableCards;
        $this->init();
    }

    /**
     * CardFlusher initialization
     */
    protected function init()
    {
        foreach ($this->initialCards as $initialCard) {

            // Add 2 cards in deck,to allow pairs searching
            $this->shuffledCards[] = new Card($initialCard);
            $this->shuffledCards[] = new Card($initialCard);
        }
    }

    /**
     * Shuffle the cards and get the result
     *
     * @return array cards array shuffled
     */
    public function shuffle(): array
    {
        shuffle($this->shuffledCards);
        return $this->shuffledCards;
    }
}