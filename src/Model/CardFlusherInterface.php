<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 21/12/18
 * Time: 14:53
 */

namespace App\Model;

/**
 * Interface CardFlusherInterface
 */
interface CardFlusherInterface
{
    /**
     * @param array $initialCards
     *
     * @return void
     */
    public function init(array $initialCards);

    /**
     * @return array[Card]
     */
    public function flush(): array;
}