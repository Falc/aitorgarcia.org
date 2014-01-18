<?php
/**
 * This file contains the AdminCommentController class.
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

    /**
     * Displays the "comment edit" form and processes it.
     *
     * @param   integer $id     The ID of the comment to edit.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected comment
        $comment = $em->getRepository('AitorGarciaBlogBundle:Comment')->find($id);

        // If the comment does not exist, display an error message
        if ($comment === null)
        {
            $errorMessage = $this->get('translator')->trans('comments.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Create the form and set the data
        $form = $this->createForm(new CommentType, $comment);

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Persist the entity
            $em->persist($comment);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('comments.message.success_edition');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the comment list
            return $this->redirect($this->generateUrl('blog_admin_comment_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaBlogBundle:Admin:comment_edit.html.twig',
            array(
                'form'       => $form->createView(),
                'comment_id' => $comment->getId()
            )
        );
    }
}
