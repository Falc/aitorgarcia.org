<?php

namespace AitorGarcia\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function moreInfoAction()
    {
        // Render the more_info view
        return $this->render('AitorGarciaAppBundle:Default:more_info.html.twig');
    }
}
