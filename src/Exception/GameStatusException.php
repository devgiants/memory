<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 26/12/18
 * Time: 13:37
 */

namespace App\Exception;


use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * This exception must be thrown when an invalid status is given the game
 * Class GameStatusException
 *
 * @package App\Exception
 */
class GameStatusException extends Exception
{

}