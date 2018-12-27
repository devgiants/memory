<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 26/12/18
 * Time: 17:25
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{

    public function findAllGames() {
        $qb = $this->createQueryBuilder('g');

//        $qb

    }
}