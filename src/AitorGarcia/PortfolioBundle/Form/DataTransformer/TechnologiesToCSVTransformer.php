<?php
/**
 * This file contains the TechnologiesToCSVTransformer class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2013 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Form\DataTransformer;

use AitorGarcia\PortfolioBundle\Entity\Technology;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms an ArrayCollection of Technologies into a CSV string and vice versa.
 */
class TechnologiesToCSVTransformer implements DataTransformerInterface
{
    /**
     * Object manager.
     *
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * Constructor.
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Transforms an ArrayCollection of Technologies into a CSV string.
     *
     * @param  ArrayCollection|null $technologies
     * @return string
     */
    public function transform($technologies)
    {
        // If $technologies is empty, return an empty string
        if (empty($technologies))
        {
            return '';
        }

        $technologiesArray = array();

        // For each technology get its name
        foreach ($technologies as $technology)
        {
            $technologiesArray[] = $technology->getName();
        }

        // Join the technologies into a comma-separated string and return it
        return implode(',', $technologiesArray);
    }

    /**
     * Transforms a string into an ArrayCollection of Technologies.
     *
     * @param  string   $technologiesString
     * @return ArrayCollection|null
     */
    public function reverseTransform($technologiesString)
    {
        $technologies = new ArrayCollection();

        // If $technologiesString is empty, return an empty ArrayCollection
        if (empty($technologiesString))
        {
            return $technologies;
        }

        // Split the comma-separated list and trim each technology
        $technologiesArray = explode(',', trim($technologiesString, ','));
        foreach ($technologiesArray as &$technologyElement)
        {
            $technologyElement = trim($technologyElement);
        }
        unset($technologyElement);

        // Remove duplicates
        $technologiesArray = array_unique($technologiesArray);

        // Get the technology repository
        $technologyRepository = $this->objectManager->getRepository('AitorGarciaPortfolioBundle:Technology');

        foreach ($technologiesArray as $technologyElement)
        {
            // Try to find the technology
            $technology = $technologyRepository->findOneBy(
                array('name' => $technologyElement)
            );

            // If the technology does not exist, create it
            if ($technology === null)
            {
                $technology = new Technology();
                $technology->setName($technologyElement);
            }

            // Add the technology to the array collection
            $technologies->add($technology);
        }

        return $technologies;
    }
}
