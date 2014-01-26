<?php
/**
 * This file contains the ProjectController class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2012-2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
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
     *
     * @param   integer $page   Current page.
     */
    public function listAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        // Find all the projects and paginate them
        $query = $em->createQuery('
            SELECT project
            FROM AitorGarciaPortfolioBundle:Project project
            ORDER BY project.createdAt DESC
        ');

        $paginator = $this->get('knp_paginator');
        $projects = $paginator->paginate($query, $page, 6);

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Project:project_list.html.twig',
            array(
                'projects' => $projects
            )
        );
    }

    /**
     * Displays the list of projects tagged with the specified technology.
     *
     * @param   string  $slug   Technology slug.
     * @param   integer $page   Current page.
     */
    public function listByTechnologyAction($slug, $page)
    {
        $em = $this->getDoctrine()->getManager();

        // Find the selected technology
        $technology = $em->getRepository('AitorGarciaPortfolioBundle:Technology')->findOneBySlug($slug);

        // These are the default values
        $technologyName = $slug;
        $projects = array();

        if ($technology !== null)
        {
            $technologyName = $technology->getName();

            // Find all the projects tagged with the specified technology
            $query = $em->createQuery('
                SELECT project
                FROM AitorGarciaPortfolioBundle:Project project
                LEFT JOIN project.technologies technology
                WHERE technology.slug = :slug
                ORDER BY project.createdAt DESC
            ');
            $query->setParameter('slug', $slug);

            $paginator = $this->get('knp_paginator');
            $projects = $paginator->paginate($query, $page, 6);
        }

        // Render the view
        return $this->render(
            'AitorGarciaPortfolioBundle:Project:project_list.html.twig',
            array(
                'projects'       => $projects,
                'technologyName' => $technologyName
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
        $query = $em->createQueryBuilder()
            ->select('project')
            ->from('AitorGarciaPortfolioBundle:Project', 'project')
            ->where('project.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->setHint(
                \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
                'Gedmo\Translatable\Query\TreeWalker\TranslationWalker'
            );

        $project = $query->getOneOrNullResult();

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
