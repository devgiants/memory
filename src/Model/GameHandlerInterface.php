<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/12/18
 * Time: 16:19
 */

namespace App\Model;


interface GameHandlerInterface
{
    /**
     * @return CardFlusherInterface
     */
    public function getCardsFlusher(): CardFlusherInterface;
}