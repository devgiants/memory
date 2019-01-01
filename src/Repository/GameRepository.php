<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 26/12/18
 * Time: 17:25
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

/**
 * Class GameRepository
 *
 * @package App\Repository
 */
class GameRepository extends EntityRepository
{

    /**
     * Override findAll to add order by parameters
     * @return array ALl games found
     */
    public function findAll()
    {
        return $this->findBy([], ['startDate' => 'DESC']);
    }
}