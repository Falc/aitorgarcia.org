<?php
/**
 * This file contains the AdminTechnologyController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012-2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Technology;
use AitorGarcia\PortfolioBundle\Form\Type\TechnologyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains backend actions related to technologies.
 */
class AdminTechnologyController extends Controller
{
    /**
     * Displays a list of technologies.
     */
    public function listAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        // Find all the technologies
        $query = $em->createQuery('
            SELECT technology
            FROM AitorGarciaPortfolioBundle:Technology technology
            ORDER BY technology.id ASC
        ');

        $paginator = $this->get('knp_paginator');
        $technologies = $paginator->paginate($query, $page, 3);

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:technology_list.html.twig',
            array(
                'technologies' => $technologies
            )
        );
    }

    /**
     * Displays the "technology create" form and processes it.
     */
    public function createAction()
    {
        // Create a blank technology and the form
        $technology = new Technology();
        $form = $this->createForm(new TechnologyType(), $technology);

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Get the entity manager and persist the entity
            $em = $this->getDoctrine()->getManager();
            $em->persist($technology);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('technologies.message.success_creation');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the technology list
            return $this->redirect($this->generateUrl('portfolio_admin_technology_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:technology_create.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Displays the "technology edit" form and processes it.
     *
     * @param   integer $id The ID of the technology to edit.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected technology
        $technology = $em->getRepository('AitorGarciaPortfolioBundle:Technology')->find($id);

        // If the technology does not exist, display an error message
        if ($technology === null)
        {
            $errorMessage = $this->get('translator')->trans('technologies.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Create the form and set the data
        $form = $this->createForm(new TechnologyType(), $technology);

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Persist the entity
            $em->persist($technology);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('technologies.message.success_edition');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the technology list
            return $this->redirect($this->generateUrl('portfolio_admin_technology_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:technology_edit.html.twig',
            array(
                'form'          => $form->createView(),
                'technology_id' => $technology->getId()
            )
        );
    }

    /**
     * Displays the "technology delete" form and processes it.
     *
     * @param   integer $id The ID of the technology to delete.
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected technology
        $technology = $em->getRepository('AitorGarciaPortfolioBundle:Technology')->find($id);

        // If the technology does not exist, display an error message
        if ($technology === null)
        {
            $errorMessage = $this->get('translator')->trans('technologies.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Create a "fake" form
        $form = $this->createDeleteForm($id);

        $request = $this->getRequest();

        // If the cancel button was pressed, redirect the user to the technology list
        if ($request->request->has('cancel') === true)
        {
            return $this->redirect($this->generateUrl('portfolio_admin_technology_list'));
        }

        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Remove the entity
            $em->remove($technology);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('technologies.message.success_deletion');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the technology list
            return $this->redirect($this->generateUrl('portfolio_admin_technology_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:technology_delete.html.twig',
            array(
                'form'              => $form->createView(),
                'technology_id'     => $technology->getId(),
                'technology_name'   => $technology->getName()
            )
        );
    }

    /**
     * Creates a helper delete form.
     *
     * @param   integer $id     The ID of the technology to delete.
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                    ->add('id', 'hidden')
                    ->getForm();
    }
}
