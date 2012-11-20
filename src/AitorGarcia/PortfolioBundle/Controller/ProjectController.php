<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectController extends Controller
{
    public function listAction()
    {
        // Get the entity manager and the project repository
        $entityManager = $this->get('doctrine')->getEntityManager();
        $projectRepository = $entityManager->getRepository('AitorGarciaPortfolioBundle:Project');

        // Find all the projects sorted by DESC creation date
        $projects = $projectRepository->findBy(
            array(),
            array('created' => 'DESC')
        );

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Project:project_list.html.twig',
            array('projects' => $projects)
        );
    }

    public function showAction($url)
    {
        // Get the entity manager and find the selected project
        $entityManager = $this->get('doctrine')->getEntityManager();
        $project = $entityManager->getRepository('AitorGarciaPortfolioBundle:Project')->findOneByUrl($url);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            throw $this->createNotFoundException('No existe el proyecto seleccionado');
        }

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Project:project_show.html.twig',
            array('project' => $project)
        );
    }
}
