<?php
/**
 * This file contains the DefaultController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains some basic actions.
 */
class DefaultController extends Controller
{
    /**
     * Redirects to the localized index.
     */
    public function preIndexAction()
    {
        // Redirect to the localized index
        return $this->redirect($this->generateUrl('index'));
    }

    /**
     * Displays the "index" view.
     */
    public function indexAction()
    {
        // Render the index view
        return $this->render('AitorGarciaAppBundle:Default:index.html.twig');
    }

    /**
     * Displays the "more info" view.
     */
    public function moreInfoAction()
    {
        // Render the more_info view
        return $this->render('AitorGarciaAppBundle:Default:more_info.html.twig');
    }
}
