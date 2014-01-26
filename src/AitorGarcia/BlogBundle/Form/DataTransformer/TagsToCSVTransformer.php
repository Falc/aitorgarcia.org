<?php
/**
 * This file contains the TagsToCSVTransformer class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Form\DataTransformer;

use AitorGarcia\BlogBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms an ArrayCollection of Tags into a CSV string and vice versa.
 */
class TagsToCSVTransformer implements DataTransformerInterface
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
     * Transforms an ArrayCollection of Tags into a CSV string.
     *
     * @param  ArrayCollection|null $tags
     * @return string
     */
    public function transform($tags)
    {
        // If $tags is empty, return an empty string
        if (empty($tags))
        {
            return '';
        }

        $tagsArray = array();

        // For each tag get its name
        foreach ($tags as $tag)
        {
            $tagsArray[] = $tag->getName();
        }

        // Join the tags into a comma-separated string and return it
        return implode(',', $tagsArray);
    }

    /**
     * Transforms a string into an ArrayCollection of Tags.
     *
     * @param  string   $tagsString
     * @return ArrayCollection|null
     */
    public function reverseTransform($tagsString)
    {
        $tags = new ArrayCollection();

        // If $tagsString is empty, return an empty ArrayCollection
        if (empty($tagsString))
        {
            return $tags;
        }

        // Split the comma-separated list and trim each tag
        $tagsArray = explode(',', trim($tagsString, ','));
        foreach ($tagsArray as &$tagElement)
        {
            $tagElement = trim($tagElement);
        }
        unset($tagElement);

        // Remove duplicates
        $tagsArray = array_unique($tagsArray);

        // Get the tag repository
        $tagRepository = $this->objectManager->getRepository('AitorGarciaBlogBundle:Tag');

        foreach ($tagsArray as $tagElement)
        {
            // Try to find the tag
            $tag = $tagRepository->findOneBy(
                array('name' => $tagElement)
            );

            // If the tag does not exist, create it
            if ($tag === null)
            {
                $tag = new Tag();
                $tag->setName($tagElement);
            }

            // Add the tag to the array collection
            $tags->add($tag);
        }

        return $tags;
    }
}
