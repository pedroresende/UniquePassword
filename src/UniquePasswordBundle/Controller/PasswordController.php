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
        return $this->render('UniquePasswordBundle:Password:add.html.twig');
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
        return $this->render('UniquePasswordBundle:Password:retrieve.html.twig');
    }

    public function getListAction()
    {
        $contents = $this->getDoctrine()->getRepository('UniquePasswordBundle:Content')->findAll();

        $listOfContents = array();
        foreach ($contents as $content) {
            $loginContent = new Login();
            $listOfContents[] = ['id' => $content->getId(), 'name' => $content->getName(), 'category' => $content->getCategory()->getName(), 'created' => $content->getCreated()->format('d/m/Y H:i:s'), 'modified' => $content->getModified()->format('d/m/Y H:i:s'), 'content' => $loginContent->decode($content->getContent(), $this->container, $this->getUser()->getPassword())];
        }

        $response = new Response();
        $response->setContent(json_encode($listOfContents));
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
