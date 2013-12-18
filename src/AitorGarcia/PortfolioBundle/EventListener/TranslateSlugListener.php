<?php
/**
 * This file contains the TranslateSlugListener class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2013 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Listener for getting translated slugs when they could be needed to build localized routes.
 */
class TranslateSlugListener
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            // don't do anything if it's not the master request
            return;
        }

        $rawRoute = $request->attributes->get('_route');

        if ($rawRoute === null)
        {
            return;
        }

        $routeParts = explode('.', $rawRoute);
        $route = $routeParts[0];
        $currentLocale = end($routeParts);

        switch ($route)
        {
            case 'project_show':
                $slug = $request->attributes->get('slug');

                if ($slug === null)
                {
                    return;
                }
                // Find the project ID from a translated slug
                $stmt = $this->em->getConnection()->prepare('
                    SELECT foreign_key AS project_id FROM projects_translations
                    WHERE field = :field AND content = :content
                ');
                $stmt->bindValue('field', 'slug');
                $stmt->bindValue('content', $slug);
                $stmt->execute();

                $resultSet = $stmt->fetchAll();
                $projectId = $resultSet[0]['project_id'] ?: null;

                // Find the slug translations
                $stmt = $this->em->getConnection()->prepare('
                    SELECT locale, content AS slug FROM projects_translations
                    WHERE foreign_key = :project_id AND field = :field
                ');
                $stmt->bindValue('project_id', $projectId);
                $stmt->bindValue('field', 'slug');
                $stmt->execute();

                $resultSet = $stmt->fetchAll();

                foreach ($resultSet as $result)
                {
                    $request->attributes->set('slug.'.$result['locale'], $result['slug']);
                }

                break;
        }
    }
}
