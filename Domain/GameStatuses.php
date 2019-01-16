<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 24/12/18
 * Time: 18:34
 */

namespace Domain;

/**
 * Class GameStatuses
 * Hold all game statuses
 *
 * @package Memory
 */
final class GameStatuses
{
    /**
     * Game status when a game is being played (meaning that game time is not reached compared to game initial start)
     */
    const IN_PROGRESS = 'in_progress';

    /**
     * Game is won
     */
    const WON = 'won';

    /**
     * Game is lost
     */
    const LOST = 'lost';
}