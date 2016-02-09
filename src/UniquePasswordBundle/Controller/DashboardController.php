<?php

namespace UniquePasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of Dashboard
 *
 * @author pedroresende
 */
class DashboardController extends Controller
{

    public function indexAction()
    {
        return $this->render('UniquePasswordBundle:Dashboard:index.html.twig');
    }

}
