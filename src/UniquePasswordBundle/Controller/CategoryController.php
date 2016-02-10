<?php

namespace UniquePasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of CategoryController
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */
class CategoryController extends Controller
{

    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository('UniquePasswordBundle:Category')->findAll();
        $categoriesCounter = [];
        foreach ($categories as $category) {
            $category->counter = $this->getDoctrine()->getRepository('UniquePasswordBundle:Category')->findNumberOfPasswords($category->getName())[0][1];
        }

        return $this->render('UniquePasswordBundle:Category:categories.html.twig', ['categories' => $categories, 'categoriesCounter' => $categoriesCounter]);
    }

    public function getListAction()
    {
        $categories = $this->getDoctrine()->getRepository('UniquePasswordBundle:Category')->findAll();

        $listOfCategories = [];
        foreach ($categories as $category) {
            $listOfCategories[] = ['id' => $category->getId(), 'name' => $category->getName()];
        }

        $response = new Response();
        $response->setContent(json_encode($listOfCategories));
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }

}
