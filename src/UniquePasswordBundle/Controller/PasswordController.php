<?php

namespace UniquePasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UniquePasswordBundle\Entity\Content;
use UniquePasswordBundle\Form\ContentType;

/**
 * Description of PasswordController
 *
 * @author pedroresende
 */
class PasswordController extends Controller
{

    public function addAction()
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);

        return $this->render('UniquePasswordBundle:Password:add.html.twig',['form' => $form->createView()]);
    }

    public function listAction()
    {
        return $this->render('UniquePasswordBundle:Password:retrieve.html.twig');
    }

}
