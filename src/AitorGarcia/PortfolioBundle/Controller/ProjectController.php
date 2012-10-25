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

    public function showAction($url)
    {
        $entityManager = $this->get('doctrine')->getEntityManager();
        $project = $entityManager->getRepository('PortfolioBundle:Project')->findOneByUrl($url);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            throw $this->createNotFoundException('No existe el proyecto seleccionado');
        }

        return $this->render(
            'PortfolioBundle:Project:project_show.html.twig',
            array('project' => $project)
        );
    }
}
