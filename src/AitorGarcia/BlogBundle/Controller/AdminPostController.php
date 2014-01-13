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

    /**
     * Displays the "post create" form and processes it.
     */
    public function createAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Create a blank post and the form
        $post = new Post();

        // Find all the tags
        $tagRepository = $em->getRepository('AitorGarciaBlogBundle:Tag');
        $tags = $tagRepository->findAllTagNames();

        // Create the form and set the data
        $form = $this->createForm(
            new PostType(),
            $post,
            array(
                'em'    => $em,
                'tags'  => $tags
            )
        );

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Persist the entity
            $em->persist($post);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('posts.message.success_creation');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the post list
            return $this->redirect($this->generateUrl('blog_admin_post_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaBlogBundle:Admin:post_create.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Displays the "post edit" form and processes it.
     *
     * @param   integer $id The ID of the post to edit.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected post
        $post = $em->getRepository('AitorGarciaBlogBundle:Post')->find($id);

        // If the post does not exist, display an error message
        if ($post === null)
        {
            $errorMessage = $this->get('translator')->trans('posts.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Find all the tags
        $tagRepository = $em->getRepository('AitorGarciaBlogBundle:Tag');
        $tags = $tagRepository->findAllTagNames();

        // Create the form and set the data
        $form = $this->createForm(
            new PostType(),
            $post,
            array(
                'em'    => $em,
                'tags'  => $tags
            )
        );

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Persist the entity
            $em->persist($post);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('posts.message.success_edition');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the post list
            return $this->redirect($this->generateUrl('blog_admin_post_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaBlogBundle:Admin:post_edit.html.twig',
            array(
                'form'      => $form->createView(),
                'post_id'   => $post->getId()
            )
        );
    }
}
