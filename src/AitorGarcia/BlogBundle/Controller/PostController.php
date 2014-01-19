<?php
/**
 * This file contains the PostController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Controller;

use AitorGarcia\BlogBundle\Entity\Comment;
use AitorGarcia\BlogBundle\Form\Type\CommentType;
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

    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected post
        $post = $em->getRepository('AitorGarciaBlogBundle:Post')->findOneBySlug($slug);

        // If the post does not exist, display an error message
        if ($post === null)
        {
            $errorMessage = $this->get('translator')->trans('posts.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Create a blank comment
        $comment = new Comment();

        // Create the form and set the data
        $form = $this->createForm(new CommentType, $comment);


        // Render the view
        return $this->render(
            'AitorGarciaBlogBundle:Post:post_show.html.twig',
            array(
                'post' => $post,
                'form' => $form->createView()
            )
        );
    }
}
