<?php
/**
 * This file contains the AdminProjectController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012-2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Project;
use AitorGarcia\PortfolioBundle\Form\Type\ProjectType;
use AitorGarcia\PortfolioBundle\Form\Type\ProjectTranslationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains backend actions related to projects.
 */
class AdminProjectController extends Controller
{
    /**
     * Displays a list of projects.
     */
    public function listAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        // Find all the projects and paginate them
        $query = $em->createQuery('
            SELECT project
            FROM AitorGarciaPortfolioBundle:Project project
            ORDER BY project.createdAt DESC
        ');

        $paginator = $this->get('knp_paginator');
        $projects = $paginator->paginate($query, $page, 10);

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_list.html.twig',
            array(
                'projects' => $projects
            )
        );
    }

    /**
     * Displays the "project create" form and processes it.
     */
    public function createAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Create a blank project and the form
        $project = new Project();

        // Find all the technologies
        $technologiesRepository = $em->getRepository('AitorGarciaPortfolioBundle:Technology');
        $technologies = $technologiesRepository->findAllTechnologyNames();

        // Create the form and set the data
        $form = $this->createForm(
            new ProjectType(),
            $project,
            array(
                'em'            => $em,
                'technologies'  => $technologies
            )
        );

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Persist the entity
            $em->persist($project);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('projects.message.success_creation');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the project list
            return $this->redirect($this->generateUrl('portfolio_admin_project_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_create.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Displays the "project edit" form and processes it.
     *
     * @param   integer $id     The ID of the project to edit.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected project
        $project = $em->getRepository('AitorGarciaPortfolioBundle:Project')->find($id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            $errorMessage = $this->get('translator')->trans('projects.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Get a copy of the screenshots contained in the project before the form submission
        $originalScreenshots = array();

        foreach ($project->getScreenshots() as $screenshot)
        {
            $originalScreenshots[] = $screenshot;
        }

        // Find all the technologies
        $technologiesRepository = $em->getRepository('AitorGarciaPortfolioBundle:Technology');
        $technologies = $technologiesRepository->findAllTechnologyNames();

        // Create the form and set the data
        $form = $this->createForm(
            new ProjectType(),
            $project,
            array(
                'em'            => $em,
                'technologies'  => $technologies
            )
        );

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // Compare the submitted screenshots with the original ones
            foreach ($project->getScreenshots() as $screenshot)
            {
                foreach ($originalScreenshots as $key => $originalScreenshot)
                {
                    // $originalScreenshots will contain only the screenshots that should be deleted
                    if ($originalScreenshot->getId() === $screenshot->getId())
                    {
                        unset($originalScreenshots[$key]);
                    }
                }
            }

            // Delete every screenshot in $originalScreenshot
            foreach ($originalScreenshots as $screenshot)
            {
                $project->removeScreenshot($screenshot);
                $em->remove($screenshot);
            }

            // 1) Persist the entity
            $em->persist($project);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('projects.message.success_edition');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the project list
            return $this->redirect($this->generateUrl('portfolio_admin_project_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_edit.html.twig',
            array(
                'form'          => $form->createView(),
                'project_id'    => $project->getId()
            )
        );
    }

    /**
     * Displays the "project delete" form and processes it.
     *
     * @param   integer $id     The ID of the project to delete.
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected project
        $project = $em->getRepository('AitorGarciaPortfolioBundle:Project')->find($id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            $errorMessage = $this->get('translator')->trans('projects.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Create a "fake" form
        $form = $this->createDeleteForm($id);

        $request = $this->getRequest();

        // If the cancel button was pressed, redirect the user to the project list
        if ($request->request->has('cancel') === true)
        {
            return $this->redirect($this->generateUrl('portfolio_admin_project_list'));
        }

        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Remove the entity
            $em->remove($project);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('projects.message.success_deletion');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the project list
            return $this->redirect($this->generateUrl('portfolio_admin_project_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_delete.html.twig',
            array(
                'form'          => $form->createView(),
                'project_id'    => $project->getId(),
                'project_name'  => $project->getName()
            )
        );
    }

    /**
     * Displays the "project translation edit" form and processes it.
     *
     * @param   integer $id             The ID of the project to translate.
     * @param   string  $transLocale    The locale code.
     */
    public function translationEditAction($id, $transLocale)
    {
        $locale = $transLocale;

        $em = $this->getDoctrine()->getManager();

        // Find the selected project
        $project = $em->getRepository('AitorGarciaPortfolioBundle:Project')->find($id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            $errorMessage = $this->get('translator')->trans('projects.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Load the translations specified by $locale
        $project->setTranslatableLocale($locale);
        $em->refresh($project);

        foreach ($project->getScreenshots() as $screenshot)
        {
            $screenshot->setTranslatableLocale($locale);
            $em->refresh($screenshot);
        }

        // Create the form and set the data
        $form = $this->createForm(new ProjectTranslationType(), $project);

        $request = $this->getRequest();
        $form->handleRequest($request);

        // If the form data is valid:
        if ($form->isValid())
        {
            // 1) Persist the entity translation
            $project->setTranslatableLocale($locale);
            $em->persist($project);
            $em->flush();

            // 2) Display a success message
            $successMessage = $this->get('translator')->trans('projects.message.success_translation');
            $request->getSession()->getFlashBag()->add('success', $successMessage);

            // 3) Redirect the user to the project translation list
            return $this->redirect($this->generateUrl('portfolio_admin_project_list'));
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_translation_edit.html.twig',
            array(
                'form'              => $form->createView(),
                'project_id'        => $project->getId(),
                'project_name'      => $project->getName(),
                'project_locale'    => $locale
            )
        );
    }

    /**
     * Creates a helper delete form.
     *
     * @param   integer $id     The ID of the project to delete.
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                    ->add('id', 'hidden')
                    ->getForm();
    }
}
