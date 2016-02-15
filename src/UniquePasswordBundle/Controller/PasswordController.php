<?php

namespace UniquePasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    
    public function addNewAction(Request $request)
    {
        var_dump(json_decode($request->getContent())->senddata);
        
        $response = new Response();
        return $response;
    }

    public function listAction()
    {
        return $this->render('UniquePasswordBundle:Password:retrieve.html.twig');
    }

}
