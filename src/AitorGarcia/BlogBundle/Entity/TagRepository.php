<?php
/**
 * This file contains the TagRepository class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Contains methods to find tags.
 */
class TagRepository extends EntityRepository
{
    /**
     * Finds the names of all the existing tags.
     *
     * @return  array
     */
    public function findAllTagNames()
    {
        $em = $this->getEntityManager();

        // Create a query that selects all the tag names sorted alphabetically
        $query = $em->createQueryBuilder()
            ->select('tag.name')
            ->from('AitorGarciaBlogBundle:Tag', 'tag')
            ->orderBy('tag.name', 'ASC')
            ->getQuery();

        // Convert the nested resulting array into a plain one
        $result = array_map('current', $query->getArrayResult());

        return $result;
    }
}
