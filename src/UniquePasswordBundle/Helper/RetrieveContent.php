<?php

namespace UniquePasswordBundle\Helper;

use UniquePasswordBundle\Entity\Content;
use UniquePasswordBundle\Category\Login;

/**
 * Description of RetrieveContent
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */
class RetrieveContent
{

    private $container;
    private $em;
    private $logger;

    public function __construct($container, $doctrine, $logger)
    {
        $this->container = $container;
        $this->em = $doctrine;
        $this->logger = $logger;
    }

    public function getEntry($contentEncoded, $user)
    {
        switch ($contentEncoded->getCategory()->getId()) {
            case '1': {
                    return $this->getLogin($contentEncoded, $user, $contentEncoded->getCategory()->getId());
                    //$this->logger->info('Added new Login entry to the database');
                    //return ['httpStatus' => Response::HTTP_CREATED, 'message' => 'New Login information added'];
                    //break;
                }
            case '2': {
                    $this->getCreditCard($contentEncoded, $user, $contentEncoded->getCategory()->getId());
                    $this->logger->info('Added new Credit Card entry to the database');
                    return Response::HTTP_CREATED;
                    //break;
                }
            case '3': {
                    $this->getNote($contentEncoded, $user, $contentEncoded->getCategory()->getId());
                    $this->logger->info('Added new Note entry to the database');
                    return Response::HTTP_CREATED;
                    //break;
                }
            default: {
                    return Response::HTTP_BAD_REQUEST;
                    //break; 
                }
        }
    }

    private function getLogin($contentEncoded, $user, $categoryId)
    {
        $login = new Login();
        $content = $login->decode($contentEncoded->getContent(), $this->container, $user->getPassword());
        $content['categoryId'] = $categoryId;
        $content['name'] = $contentEncoded->getName();

        return $content;
    }
}
