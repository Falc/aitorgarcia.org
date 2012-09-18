<?php

namespace AitorGarcia\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminDefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PortfolioBundle:Admin:index.html.twig');
    }
}
