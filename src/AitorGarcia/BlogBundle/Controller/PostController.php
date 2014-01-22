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
    /**
     * Displays a list of posts.
     */
    public function listAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        // Find all the posts and paginate them
        $query = $em->createQuery('
            SELECT post
            FROM AitorGarciaBlogBundle:Post post
            ORDER BY post.createdAt DESC
        ');

        $paginator = $this->get('knp_paginator');
        $posts = $paginator->paginate($query, $page, 3);

        // Render the view
        return $this->render(
            'AitorGarciaBlogBundle:Post:post_list.html.twig',
            array(
                'posts' => $posts
            )
        );
    }

    /**
     * Displays the post view.
     *
     * @param   string  $slug   The post slug.
     */
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
        $form = $this->createForm(
            new CommentType(),
            $comment,
            array(
                'purifier' => $this->get('exercise_html_purifier.comments')
            )
        );

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Set the relationship and persist the entity
            $comment->setPost($post);
            $em->persist($comment);
            $em->flush();

            // 2) Redirect the user to the post list
            $url = $this->generateUrl('blog_post_show', array('slug' => $slug));
            $url .= '#comment-'.$post->getComments()->count();
            return $this->redirect($url);
        }

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
