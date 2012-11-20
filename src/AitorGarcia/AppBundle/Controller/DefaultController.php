<?php

namespace AitorGarcia\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function preIndexAction()
    {
        // Redirect to the localized index
        return $this->redirect($this->generateUrl('index'));
    }

    public function indexAction()
    {
        // Render the index view
        return $this->render('AitorGarciaAppBundle:Default:index.html.twig');
    }

    public function moreInfoAction()
    {
        // Render the more_info view
        return $this->render('AitorGarciaAppBundle:Default:more_info.html.twig');
    }
}
