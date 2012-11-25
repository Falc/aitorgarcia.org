<?php
/**
 * This file contains the AdminProjectController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
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
    public function listAction()
    {
        // Get the entity manager and find all the projects
        $entityManager = $this->get('doctrine')->getEntityManager();
        $projects = $entityManager->getRepository('AitorGarciaPortfolioBundle:Project')->findAll();

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_list.html.twig',
            array('projects' => $projects)
        );
    }

    /**
     * Displays the "project create" form and processes it.
     */
    public function createAction()
    {
        // Create a blank project
        $project = new Project();

        // Create the form and set the data
        $form = $this->createForm(new ProjectType(), $project);

        // Get the request
        $request = $this->get('request');

        // If the request method is POST, process the data
        if ($request->getMethod() === 'POST')
        {
            // Bind the request
            $form->bind($request);

            // If the form data is valid:
            if ($form->isValid())
            {
                // 1) Get the entity manager and persist the entity
                $entityManager = $this->get('doctrine')->getEntityManager();
                $entityManager->persist($project);
                $entityManager->flush();

                // 2) Display a success message
                $successMessage = $this->get('translator')->trans('projects.message.success_creation');
                $request->getSession()->getFlashBag()->add('success', $successMessage);

                // 3) Redirect the user to the project list
                return $this->redirect($this->generateUrl('admin_project_list'));
            }
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_create.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Displays the "project edit" form and processes it.
     *
     * @param   integer $id The ID of the project to edit.
     */
    public function editAction($id)
    {
        // Get the entity manager and find the selected project
        $entityManager = $this->get('doctrine')->getEntityManager();
        $project = $entityManager->find('AitorGarciaPortfolioBundle:Project', $id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            $successMessage = $this->get('translator')->trans('projects.message.do_not_exist');
            throw $this->createNotFoundException($successMessage);
        }

        // Get a copy of the screenshots contained in the project before the form submission
        $originalScreenshots = array();
        foreach ($project->getScreenshots() as $screenshot)
        {
            $originalScreenshots[] = $screenshot;
        }

        // Create the form and set the data
        $form = $this->createForm(new ProjectType, $project);

        // Get the request
        $request = $this->get('request');

        // If the request method is POST, process the data
        if ($request->getMethod() === 'POST')
        {
            // Bind the request
            $form->bind($request);

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
                    $entityManager->remove($screenshot);
                }

                // 1) Persist the entity
                $entityManager->persist($project);
                $entityManager->flush();

                // 2) Display a success message
                $successMessage = $this->get('translator')->trans('projects.message.success_edition');
                $request->getSession()->getFlashBag()->add('success', $successMessage);

                // 3) Redirect the user to the project list
                return $this->redirect($this->generateUrl('admin_project_list'));
            }
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_edit.html.twig',
            array(
                'form' => $form->createView(),
                'project_id' => $project->getId()
            )
        );
    }

    /**
     * Displays the "project delete" form and processes it.
     *
     * @param   integer $id The ID of the project to delete.
     */
    public function deleteAction($id)
    {
        // Get the entity manager and find the selected project
        $entityManager = $this->get('doctrine')->getEntityManager();
        $project = $entityManager->find('AitorGarciaPortfolioBundle:Project', $id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            $successMessage = $this->get('translator')->trans('projects.message.do_not_exist');
            throw $this->createNotFoundException($successMessage);
        }

        // Get the request
        $request = $this->get('request');

        // Create a "fake" form
        $form = $this->createDeleteForm($id);

        // If the request method is POST, process the data
        if ($request->getMethod() === 'POST')
        {
            // If the cancel button was pressed, redirect the user to the project list
            if ($request->request->has('cancel') === true)
            {
                return $this->redirect($this->generateUrl('admin_project_list'));
            }

            // Bind the request
            $form->bind($request);

            // If the form data is valid:
            if ($form->isValid())
            {
                // 1) Remove the entity
                $entityManager->remove($project);
                $entityManager->flush();

                // 2) Display a success message
                $successMessage = $this->get('translator')->trans('projects.message.success_deletion');
                $request->getSession()->getFlashBag()->add('success', $successMessage);

                // 3) Redirect the user to the project list
                return $this->redirect($this->generateUrl('admin_project_list'));
            }
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_delete.html.twig',
            array(
                'form' => $form->createView(),
                'project_id' => $project->getId()
            )
        );
    }

    /**
     * Displays the "project translation edit" form and processes it.
     *
     * @param   integer $id     The ID of the project to translate.
     * @param   string  $lang   The locale code of the translation language.
     */
    public function translationEditAction($id, $lang)
    {
        // Get the entity manager and find the selected project
        $entityManager = $this->get('doctrine')->getEntityManager();
        $project = $entityManager->find('AitorGarciaPortfolioBundle:Project', $id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            $successMessage = $this->get('translator')->trans('projects.message.do_not_exist');
            throw $this->createNotFoundException($successMessage);
        }

        // Load the translations specified by $lang
        $project->setTranslatableLocale($lang);
        $entityManager->refresh($project);

        foreach ($project->getScreenshots() as $screenshot)
        {
            $screenshot->setTranslatableLocale($lang);
            $entityManager->refresh($screenshot);
        }

        // Create the form and set the data
        $form = $this->createForm(new ProjectTranslationType(), $project);

        // Get the request
        $request = $this->get('request');

        // If the request method is POST, process the data
        if ($request->getMethod() === 'POST')
        {
            // Bind the request
            $form->bind($request);

            // If the form data is valid:
            if ($form->isValid())
            {
                // 1) Persist the entity translation
                $project->setTranslatableLocale($lang);
                $entityManager->persist($project);
                $entityManager->flush();

                // 2) Display a success message
                $successMessage = $this->get('translator')->trans('projects.message.success_translation');
                $request->getSession()->getFlashBag()->add('success', $successMessage);

                // 3) Redirect the user to the project translation list
                return $this->redirect($this->generateUrl('admin_project_list'));
            }
        }

        // Render the form
        return $this->render(
            'AitorGarciaPortfolioBundle:Admin:project_translation_edit.html.twig',
            array(
                'form' => $form->createView(),
                'project_id' => $project->getId(),
                'project_name' => $project->getName(),
                'lang' => $lang
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
