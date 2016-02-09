<?php

namespace UniquePasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of PasswordController
 *
 * @author pedroresende
 */
class PasswordController extends Controller
{

    public function addAction()
    {
        return $this->render('UniquePasswordBundle:Password:add.html.twig');
    }

    public function retrieveAction()
    {
        return $this->render('UniquePasswordBundle:Password:retrieve.html.twig');
    }

    public function categoriesAction()
    {
        return $this->render('UniquePasswordBundle:Password:categories.html.twig');
    }

}
