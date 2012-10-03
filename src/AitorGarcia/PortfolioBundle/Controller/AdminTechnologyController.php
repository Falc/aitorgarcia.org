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

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}
