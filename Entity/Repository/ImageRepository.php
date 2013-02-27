<?php

namespace Desarrolla2\Bundle\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends EntityRepository {

    /**
     * 
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilderForFilter() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb
                ->select('i')
                ->from('BlogBundle:Image', 'i')
                ->orderBy('i.updatedAt', 'DESC')
        ;
        return $qb;
    }

}