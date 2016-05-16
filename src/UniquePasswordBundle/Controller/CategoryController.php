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
    public function getListAction()
    {
        $categories = $this->getDoctrine()->getRepository('UniquePasswordBundle:Category')->findAll();

        $listOfCategories = [];
        foreach ($categories as $category) {
            $NumberOfCategory = $this->getDoctrine()->getRepository('UniquePasswordBundle:Category')->findNumberOfPasswords($category->getName())[0][1];
            $listOfCategories[] = ['id' => $category->getId(), 'icon' => $category->getIcon(), 'name' => $category->getName(), 'categoryCounter' => $NumberOfCategory];
        }

        $response = new Response();
        $response->setContent(json_encode($listOfCategories));
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
