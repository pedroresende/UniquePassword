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

    public function viewAction()
    {
        return $this->render('UniquePasswordBundle:Password:view.html.twig');
    }

    public function getContentAction($id)
    {
        $content = $this->getDoctrine()->getRepository('UniquePasswordBundle:Content')->find($id);

        if (isset($content)) {
            $retrievecontent = $this->get('unique_password.retrievecontent');
            $decodedContent = $retrievecontent->getEntry($content, $this->getUser());
        }

        $response = new Response();
        $response->setContent(json_encode($decodedContent));
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }

    public function updateAction(Request $request, $id)
    {
        $sentContent = json_decode($request->getContent())->senddata;

        $createContent = $this->get('unique_password.createcontent');
        $responseArray = $createContent->updateEntry($id, $sentContent, $this->getUser());

        $response = new Response();
        $response->setStatusCode($responseArray['httpStatus']);
        $response->setContent($responseArray['message']);

        return $response;
    }
}
