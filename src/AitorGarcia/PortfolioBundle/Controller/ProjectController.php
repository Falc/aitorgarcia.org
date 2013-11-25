<?php
/**
 * This file contains the ProjectController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012-2013 Aitor García <aitor.falc@gmail.com>
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
        $em = $this->getDoctrine()->getManager();

        // Find all the projects sorted by DESC creation date
        $projects = $em->getRepository('AitorGarciaPortfolioBundle:Project')->findBy(
            array(),
            array(
                'created' => 'DESC'
            )
        );

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Project:project_list.html.twig',
            array(
                'projects' => $projects
            )
        );
    }

    /**
     * Displays the project view.
     *
     * @param   string  $slug   The project slug.
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected project
        $project = $em->getRepository('AitorGarciaPortfolioBundle:Project')->findOneBySlug($slug);

        // If the project does not exist, display an error message
        if ($project === null)
        {
            $errorMessage = $this->get('translator')->trans('projects.message.do_not_exist');
            throw $this->createNotFoundException($errorMessage);
        }

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Project:project_show.html.twig',
            array(
                'project' => $project
            )
        );
    }
}
