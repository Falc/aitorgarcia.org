<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectController extends Controller
{
    public function listAction()
    {
        $entityManager = $this->get('doctrine')->getEntityManager();
        $projects = $entityManager->getRepository('PortfolioBundle:Project')->findAll();

        return $this->render(
            'PortfolioBundle:Project:project_list.html.twig',
            array('projects' => $projects)
        );
    }
}
