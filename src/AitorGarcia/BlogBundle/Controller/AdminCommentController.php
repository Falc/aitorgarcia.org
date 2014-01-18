<?php
/**
 * This file contains the AdminCommentController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains backend actions related to comments.
 */
class AdminCommentController extends Controller
{
    /**
     * Displays a list of comments.
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Find all the comments
        $comments = $em->getRepository('AitorGarciaBlogBundle:Comment')->findAll();

        // Render the view
        return $this->render(
            'AitorGarciaBlogBundle:Admin:comment_list.html.twig',
            array(
                'comments' => $comments
            )
        );
    }
}
