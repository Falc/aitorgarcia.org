<?php
/**
 * This file contains the PostController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains actions related to posts.
 */
class PostController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Find all the posts sorted by DESC creation date
        $posts = $em->getRepository('AitorGarciaBlogBundle:Post')->findBy(
            array(),
            array(
                'createdAt' => 'DESC'
            )
        );

        // Render the view
        return $this->render(
            'AitorGarciaBlogBundle:Post:post_list.html.twig',
            array(
                'posts' => $posts
            )
        );
    }
}
