<?php

namespace AitorGarcia\PortfolioBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function findTest($something)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->select('p')
            ->from('PortfolioBundle:Project', 'p')
            ->where('p.something = :something')
            ->orderBy('p.something', 'ASC')
            ->setParameter('something', new \DateTime($something), \Doctrine\DBAL\Types\Type::DATETIME)
            ->getQuery();

        return $query->getResult();
    }

}
