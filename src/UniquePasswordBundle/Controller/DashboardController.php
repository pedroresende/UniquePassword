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
        $numberOfCategories = $this->getDoctrine()->getRepository('UniquePasswordBundle:Category')->findAll();
        $numberOfKeys = $this->getDoctrine()->getRepository('UniquePasswordBundle:Content')->findAll();

        return $this->render(
            'UniquePasswordBundle:Dashboard:index.html.twig',
            [
                'numberOfKeys' => count($numberOfKeys),
                'numberOfCategories' => count($numberOfCategories)
            ]
        );
    }
}
