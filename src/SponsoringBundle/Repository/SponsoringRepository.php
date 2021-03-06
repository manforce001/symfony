<?php

namespace SponsoringBundle\Repository;

/**
 * SponsoringRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SponsoringRepository extends \Doctrine\ORM\EntityRepository
{
    public function findPublicite($publiciteID)
    {
        $entityManager = $this->getEntityManager();

        /*$query = $entityManager->createQuery('
        SELECT c,p FROM SponsoringBundle:Sponsoring c
        INNER JOIN c.candidat p
        WHERE c.id = :id')->setParameter('id', $publiciteID);
        return $query->getResult();*/

        $query = $entityManager->createQuery('
        SELECT p FROM SponsoringBundle:Sponsoring p
        WHERE p.id = :id')->setParameter('id', $publiciteID);

        return $query->getResult();
    }
}
