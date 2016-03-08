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
        $em = $this->getDoctrine()->getManager();

        switch ($sentContent->category) {
            case 1: {
                    $loginContent = new Login();
                    $loginContent->setBase($sentContent->siteUsername, $sentContent->sitePasword, $sentContent->siteSitename);

                    $content = new Content();

                    $content->setName($sentContent->name);
                    $encodedContent = $loginContent->encode($this->container, $this->getUser()->getPassword());

                    $content->setContent($encodedContent);
                    $categories = $this->getDoctrine()->getRepository('UniquePasswordBundle:Category')->find(1);

                    $content->setCategory($categories);
                    $dateNow = new \DateTime();
                    $content->setCreated($dateNow);
                    $content->setModified($dateNow);

                    $em->persist($content);
                    var_dump($content);
                    $em->flush();
                    break;
                }
        }

        $response = new Response();
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
