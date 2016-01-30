<?php

namespace UniquePasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UniquePasswordBundle:Default:index.html.twig');
    }
}
