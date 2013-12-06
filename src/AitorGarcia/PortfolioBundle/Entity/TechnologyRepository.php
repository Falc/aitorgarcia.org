<?php
/**
 * This file contains the TechnologyRepository class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2013 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Contains methods to find technologies.
 */
class TechnologyRepository extends EntityRepository
{
    /**
     * Finds the names of all the existing technologies.
     *
     * @return  array
     */
    public function findAllTechnologyNames()
    {
        $em = $this->getEntityManager();

        // Create a query that selects all the technology names sorted alphabetically
        $query = $em->createQueryBuilder()
            ->select('technology.name')
            ->from('AitorGarciaPortfolioBundle:Technology', 'technology')
            ->orderBy('technology.name', 'ASC')
            ->getQuery();

        // Convert the nested resulting array into a plain one
        $result = array_map('current', $query->getArrayResult());

        return $result;
    }
}
