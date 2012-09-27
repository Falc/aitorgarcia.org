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
        $technology = new Technology();

        $form = $this->createForm(new TechnologyType(), $technology);

        $request = $this->get('request');
        if ($request->getMethod() === 'POST')
        {
            $form->bindRequest($request);

            if ($form->isValid())
            {
                $entityManager = $this->get('doctrine')->getEntityManager();
                $entityManager->persist($technology);
                $entityManager->flush();

                $request->getSession()->setFlash('notice', 'La tecnología ha sido creada correctamente');
                
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
