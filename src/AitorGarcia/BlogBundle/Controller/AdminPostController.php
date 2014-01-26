<?php
/**
 * This file contains the AdminPostController class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
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
        $posts = $paginator->paginate($query, $page, 10);

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
     * @param   integer $id     The ID of the post to edit.
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

    /**
     * Displays the "post delete" form and processes it.
     *
     * @param   integer $id     The ID of the post to delete.
     */
    public function deleteAction($id)
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

        // Create a "fake" form
        $form = $this->createDeleteForm($id);

        $request = $this->getRequest();

        // If the cancel button was pressed, redirect the user to the post list
        if ($request->request->has('cancel') === true)
        {
            return $this->redirect($this->generateUrl('blog_admin_post_list'));
        }

        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Remove the entity
            $em->remove($post);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('posts.message.success_deletion');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the post list
            return $this->redirect($this->generateUrl('blog_admin_post_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaBlogBundle:Admin:post_delete.html.twig',
            array(
                'form'       => $form->createView(),
                'post_id'    => $post->getId(),
                'post_title' => $post->getTitle()
            )
        );
    }

    /**
     * Creates a helper delete form.
     *
     * @param   integer $id     The ID of the post to delete.
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                    ->add('id', 'hidden')
                    ->getForm();
    }
}
