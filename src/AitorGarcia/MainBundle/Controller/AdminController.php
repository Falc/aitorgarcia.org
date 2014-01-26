<?php
/**
 * This file contains the AdminController class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2012-2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Contains some basic backend actions.
 */
class AdminController extends Controller
{
    /**
     * Redirects to the localized index.
     */
    public function preIndexAction()
    {
        // Redirect to the localized index
        return $this->redirect($this->generateUrl('main_admin_index'));
    }

    /**
     * Displays the "admin index" view.
     */
    public function indexAction()
    {
        // Render the admin index view
        return $this->render('AitorGarciaMainBundle:Admin:index.html.twig');
    }
}
