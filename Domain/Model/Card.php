<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 20/12/18
 * Time: 21:30
 */

namespace Domain\Model;

/**
 * Class Card
 * Represents a card from a business POV (framework-agnostic)
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
     * Return the card name
     *
     * @return string the card name
     */
    public function getName(): string
    {
        return $this->name;
    }
}