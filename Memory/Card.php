<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 21:30
 */

namespace Memory;

/**
 * Class Card
 *
 * @package Memory
 */
class Card
{

    /**
     * @var string the card name
     */
    protected $name;

    /**
     * Card constructor.
     *
     * @param string $name the card name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Retirn the card name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}