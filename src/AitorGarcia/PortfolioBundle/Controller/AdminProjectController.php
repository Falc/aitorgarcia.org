<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Project;
use AitorGarcia\PortfolioBundle\Form\Type\ProjectType;
use AitorGarcia\PortfolioBundle\Form\Type\ProjectTranslationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminProjectController extends Controller
{
    public function listAction()
    {
        $entityManager = $this->get('doctrine')->getEntityManager();
        $projects = $entityManager->getRepository('PortfolioBundle:Project')->findAll();

        return $this->render(
            'PortfolioBundle:Admin:project_list.html.twig',
            array('projects' => $projects)
        );
    }

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
                $request->getSession()->getFlashBag()->add('success', 'El proyecto ha sido creado correctamente.');

                // 3) Redirect the user to the project list
                return $this->redirect($this->generateUrl('admin_project_list'));
            }
        }

        // Render the form
        return $this->render(
            'PortfolioBundle:Admin:project_create.html.twig',
            array('form' => $form->createView())
        );
    }

    public function editAction($id)
    {
        // Get the entity manager and find the selected project
        $entityManager = $this->get('doctrine')->getEntityManager();
        $project = $entityManager->find('PortfolioBundle:Project', $id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            throw $this->createNotFoundException('No existe el proyecto seleccionado.');
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
                $request->getSession()->getFlashBag()->add('success', 'El proyecto ha sido modificado correctamente.');

                // 3) Redirect the user to the project list
                return $this->redirect($this->generateUrl('admin_project_list'));
            }
        }

        // Render the form
        return $this->render(
            'PortfolioBundle:Admin:project_edit.html.twig',
            array(
                'form' => $form->createView(),
                'project_id' => $project->getId()
            )
        );
    }

    public function deleteAction($id)
    {
        // Get the entity manager and find the selected project
        $entityManager = $this->get('doctrine')->getEntityManager();
        $project = $entityManager->find('PortfolioBundle:Project', $id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            throw $this->createNotFoundException('No existe el proyecto seleccionado.');
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
                $request->getSession()->getFlashBag()->add('success', 'El proyecto ha sido eliminado correctamente.');

                // 3) Redirect the user to the project list
                return $this->redirect($this->generateUrl('admin_project_list'));
            }
        }

        // Render the form
        return $this->render(
            'PortfolioBundle:Admin:project_delete.html.twig',
            array(
                'form' => $form->createView(),
                'project_id' => $project->getId()
            )
        );
    }

    public function translationEditAction($id, $lang)
    {
        // Get the entity manager and find the selected project
        $entityManager = $this->get('doctrine')->getEntityManager();
        $project = $entityManager->find('PortfolioBundle:Project', $id);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            throw $this->createNotFoundException('No existe el proyecto seleccionado.');
        }

        // Load the translation specified by $lang
        $project->setLocale($lang);
        $entityManager->refresh($project);

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
                $project->setLocale($lang);
                $entityManager->persist($project);
                $entityManager->flush();

                // 2) Display a success message
                $request->getSession()->getFlashBag()->add('success', 'La traducción se ha guardado correctamente.');

                // 3) Redirect the user to the project translation list
                return $this->redirect($this->generateUrl('admin_project_list'));
            }
        }

        // Render the form
        return $this->render(
            'PortfolioBundle:Admin:project_translation_edit.html.twig',
            array(
                'form' => $form->createView(),
                'project_id' => $project->getId(),
                'project_name' => $project->getName(),
                'lang' => $lang
            )
        );
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                    ->add('id', 'hidden')
                    ->getForm();
    }
}
