<?php

namespace AitorGarcia\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        // Render the admin index view
        return $this->render('AppBundle:Admin:index.html.twig');
    }
}
