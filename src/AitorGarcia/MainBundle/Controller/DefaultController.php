<?php
/**
 * This file contains the DefaultController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\MainBundle\Controller;

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
        return $this->redirect($this->generateUrl('main_index'));
    }

    /**
     * Displays the "index" view.
     */
    public function indexAction()
    {
        return $this->render('AitorGarciaMainBundle:Default:index.html.twig');
    }
}
