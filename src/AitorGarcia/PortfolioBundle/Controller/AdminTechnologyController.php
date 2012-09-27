<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Technology;
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
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}
