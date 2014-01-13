<?php
/**
 * This file contains the AdminPostController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Controller;

use AitorGarcia\BlogBundle\Entity\Post;
use AitorGarcia\BlogBundle\Form\Type\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains backend actions related to posts.
 */
class AdminPostController extends Controller
{
    /**
     * Displays a list of post.
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Find all the posts
        $posts = $em->getRepository('AitorGarciaBlogBundle:Post')->findAll();

        // Render the view
        return $this->render(
            'AitorGarciaBlogBundle:Admin:post_list.html.twig',
            array(
                'posts' => $posts
            )
        );
    }
}
