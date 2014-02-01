<?php
/**
 * This file contains the PostController class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
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
     *
     * @param   integer $page   Current page.
     */
    public function listAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        // Find all the posts and paginate them
        $query = $em->createQuery('
            SELECT post
            FROM AitorGarciaBlogBundle:Post post
            WHERE post.isPublished = 1
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
     * Displays the list of posts tagged with the specified tag.
     *
     * @param   string  $slug   Tag slug.
     * @param   integer $page   Current page.
     */
    public function listByTagAction($slug, $page)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected tag
        $tag = $em->getRepository('AitorGarciaBlogBundle:Tag')->findOneBySlug($slug);

        // These are the default values
        $tagName = $slug;
        $posts = array();

        if ($tag !== null)
        {
            $tagName = $tag->getName();

            // Find all the posts tagged with the specified tag
            $query = $em->createQuery('
                SELECT post
                FROM AitorGarciaBlogBundle:Post post
                LEFT JOIN post.tags tag
                WHERE post.isPublished = 1
                AND tag.slug = :slug
                ORDER BY post.createdAt DESC
            ');
            $query->setParameter('slug', $slug);

            $paginator = $this->get('knp_paginator');
            $posts = $paginator->paginate($query, $page, 3);
        }

        // Render the view
        return $this->render(
            'AitorGarciaBlogBundle:Post:post_list.html.twig',
            array(
                'posts'     => $posts,
                'tagName'   => $tagName
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

    /**
     * Displays the blog feed.
     */
    public function feedAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Find the latest posts
        $query = $em->createQuery('
            SELECT post
            FROM AitorGarciaBlogBundle:Post post
            WHERE post.isPublished = 1
            ORDER BY post.createdAt DESC
        ');

        // Use the paginator to limit the results
        $paginator = $this->get('knp_paginator');
        $posts = $paginator->paginate($query, 1, 5);

        $items = array();

        foreach ($posts as $post)
        {
            $items[] = array(
                'title'         => $post->getTitle(),
                'link'          => $this->generateUrl('blog_post_show', array('slug' => $post->getSlug()), true),
                'description'   => $post->getBody(),
                'pubDate'       => $post->getCreatedAt(),
                'guid'          => $this->generateUrl('blog_post_show', array('slug' => $post->getSlug()), true)
            );
        }

        // Render the view
        $response = $this->render(
            '::base.rss.twig',
            array(
                'title'         => 'Aitor García',
                'link'          => $this->generateUrl('blog_post_list', array(), true),
                'description'   => $this->get('translator')->trans('posts.subnavigation.post_list'),
                'language'      => 'es',
                'pubDate'       => time(),
                'lastBuildDate' => time(),
                'items'         => $items
            )
        );

        // Set max-age to 10.800 seconds (3 hours)
        $response->setPublic();
        $response->setSharedMaxAge(10800);

        return $response;
    }
}
