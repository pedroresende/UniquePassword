<?php

namespace UniquePasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UniquePasswordBundle\Entity\Content;
use UniquePasswordBundle\Form\ContentType;
use UniquePasswordBundle\Category\Login;

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

        return $this->render('UniquePasswordBundle:Password:add.html.twig', ['form' => $form->createView()]);
    }

    public function addNewAction(Request $request)
    {
        $sentContent = json_decode($request->getContent())->senddata;

        $createContent = $this->get('unique_password.createcontent');
        $responseArray = $createContent->newEntry($sentContent, $this->getUser());

        $response = new Response();
        $response->setStatusCode($responseArray['httpStatus']);
        $response->setContent($responseArray['message']);
        return $response;
    }

    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository('UniquePasswordBundle:Content')->findAll();
        $encodedContent = $categories[0]->getContent();
        $loginContent = new Login();

        $content = $loginContent->decode($encodedContent, $this->container, $this->getUser()->getPassword());
        return $this->render('UniquePasswordBundle:Password:retrieve.html.twig', ['content' => $content]);
    }

}
