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
 * Used to create contract CardFlushers object must respect. Useful for flex autowiring loose coupling and type-hinting
 */
interface CardFlusherInterface
{

    /**
     * @return array card array shuffled
     */
    public function shuffle(): array;
}