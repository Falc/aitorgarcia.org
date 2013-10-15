<?php
/**
 * This file contains the ProjectController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Controller;

use AitorGarcia\PortfolioBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains actions related to projects.
 */
class ProjectController extends Controller
{
    /**
     * Displays a list of projects.
     */
    public function listAction()
    {
        // Get the entity manager and the project repository
        $entityManager = $this->getDoctrine()->getManager();
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

    /**
     * Displays the project view.
     *
     * @param   string  $slug   The project slug.
     */
    public function showAction($slug)
    {
        // Get the entity manager and find the selected project
        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository('AitorGarciaPortfolioBundle:Project')->findOneBySlug($slug);

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
