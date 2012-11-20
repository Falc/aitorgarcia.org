<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminDefaultController extends Controller
{
    public function indexAction()
    {
        // Render the index view
        return $this->render('AitorGarciaPortfolioBundle:Admin:index.html.twig');
    }
}
