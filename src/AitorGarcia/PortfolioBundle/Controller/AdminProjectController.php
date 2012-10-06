<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Project;
use AitorGarcia\PortfolioBundle\Form\Type\ProjectType;
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
                $request->getSession()->getFlashBag()->add('success', 'El proyecto ha sido creado correctamente');

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
            throw $this->createNotFoundException('No existe el proyecto seleccionada');
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
                // 1) Persist the entity
                $entityManager->persist($project);
                $entityManager->flush();

                // 2) Display a success message
                $request->getSession()->getFlashBag()->add('sucess', 'El proyecto ha sido modificado correctamente');

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

    public function deleteAction()
    {
    }
}
