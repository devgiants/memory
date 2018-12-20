<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 22:45
 */

namespace Memory;

/**
 * Class CardFlusher
 *
 * @package Memory
 */
class CardFlusher
{

    /**
     * @var array $initialCards cards initial set
     */
    protected $initialCards;

    /**
     * CardFlusher constructor.
     *
     * @param array $initialCards cards initial set
     */
    public function __construct(array $initialCards)
    {
        foreach ($initialCards as $initialCard) {
            $this->initialCards[] = new Card($initialCard);
        }
    }

    /**
     * Flush the cards and get the result
     *
     * @return array[Card]
     */
    public function flush(): array
    {
        return $this->initialCards;
    }
}