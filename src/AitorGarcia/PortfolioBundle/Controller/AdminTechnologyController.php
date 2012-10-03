<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Technology;
use AitorGarcia\PortfolioBundle\Form\Type\TechnologyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminTechnologyController extends Controller
{
    public function listAction()
    {
        $entityManager = $this->get('doctrine')->getEntityManager();
        $technologies = $entityManager->getRepository('PortfolioBundle:Technology')->findAll();

        return $this->render(
            'PortfolioBundle:Admin:technology_list.html.twig',
            array('technologies' => $technologies)
        );
    }

    public function createAction()
    {
        // Create a blank technology
        $technology = new Technology();

        // Create the form and set the data
        $form = $this->createForm(new TechnologyType(), $technology);

        // Get the request
        $request = $this->get('request');

        // If the request method is POST, process the data
        if ($request->getMethod() === 'POST')
        {
            // Bind the request
            $form->bindRequest($request);

            // If the form data is valid:
            if ($form->isValid())
            {
                // 1) Get the entity manager and persist the entity
                $entityManager = $this->get('doctrine')->getEntityManager();
                $entityManager->persist($technology);
                $entityManager->flush();

                // 2) Display a success message
                $request->getSession()->setFlash('notice', 'La tecnología ha sido creada correctamente');

                // 3) Redirect the user to the technology list
                return $this->redirect($this->generateUrl('admin_technology_list'));
            }
        }

        return $this->render(
            'PortfolioBundle:Admin:technology_create.html.twig',
            array('form' => $form->createView())
        );
    }

    public function editAction($id)
    {
        // Get the entity manager and find the selected technology
        $entityManager = $this->get('doctrine')->getEntityManager();
        $technology = $entityManager->find('PortfolioBundle:Technology', $id);

        // If the technology does not exist, display an error message
        if ($technology === null)
        {
            throw new NotFoundHttpException('No existe la tecnología seleccionada');
        }

        // Create the form and set the data
        $form = $this->createForm(new TechnologyType, $technology);

        // Get the request
        $request = $this->get('request');

        // If the request method is POST, process the data
        if ($request->getMethod() === 'POST')
        {
            // If the cancel button was pressed, redirect the user to the technology list
            if ($request->request->has('cancel') === true)
            {
                return $this->redirect($this->generateUrl('admin_technology_list'));
            }

            // Bind the request
            $form->bindRequest($request);

            // If the form data is valid:
            if ($form->isValid())
            {
                // 1) Persist the entity
                $entityManager->persist($technology);
                $entityManager->flush();

                // 2) Display a success message
                $request->getSession()->setFlash('notice', 'La tecnología ha sido modificada correctamente');

                // 3) Redirect the user to the technology list
                return $this->redirect($this->generateUrl('admin_technology_list'));
            }
        }

        // Render the form
        return $this->render(
            'PortfolioBundle:Admin:technology_edit.html.twig',
            array(
                'form' => $form->createView(),
                'technology_id' => $technology->getId()
            )
        );
    }

    public function deleteAction($id)
    {
        // Get the entity manager and find the selected technology
        $entityManager = $this->get('doctrine')->getEntityManager();
        $technology = $entityManager->find('PortfolioBundle:Technology', $id);

        // If the technology does not exist, display an error message
        if ($technology === null)
        {
            throw new NotFoundHttpException('No existe la tecnología seleccionada');
        }

        // Get the request
        $request = $this->get('request');

        // Create a "fake" form
        $form = $this->createDeleteForm($id);

        // If the request method is POST, process the data
        if ($request->getMethod() === 'POST')
        {
            // If the cancel button was pressed, redirect the user to the technology list
            if ($request->request->has('cancel') === true)
            {
                return $this->redirect($this->generateUrl('admin_technology_list'));
            }

            // Bind the request
            $form->bindRequest($request);

            // If the form data is valid:
            if ($form->isValid())
            {
                // 1) Remove the entity
                $entityManager->remove($technology);
                $entityManager->flush();

                // 2) Display a success message
                $request->getSession()->setFlash('notice', 'La tecnología ha sido modificada correctamente');

                // 3) Redirect the user to the technology list
                return $this->redirect($this->generateUrl('admin_technology_list'));
            }
        }

        // Render the form
        return $this->render(
            'PortfolioBundle:Admin:technology_delete.html.twig',
            array(
                'form' => $form->createView(),
                'technology_id' => $technology->getId()
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
