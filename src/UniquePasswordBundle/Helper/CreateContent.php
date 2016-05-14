<?php

namespace UniquePasswordBundle\Helper;

use UniquePasswordBundle\Entity\Content;
use UniquePasswordBundle\Category\Login;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of CreateContent
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */
class CreateContent
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

    /**
     * This method is responsible managing a newEntry
     *
     * @param stdObject $entryContent contains the content that has been passed
     * by the form
     * @param Symfony\Bundle\FrameworkBundle\Controller $user
     * @return type
     */
    public function newEntry($entryContent, $user)
    {
        switch ($entryContent->category) {
            case '1': {
                    $this->createLogin($entryContent, $user);
                    $this->logger->info('Added new Login entry to the database');
                    return ['httpStatus' => Response::HTTP_CREATED, 'message' => 'New Login information added'];
                    //break;
                }
            case '2': {
                    $this->createCreditCard($entryContent, $user);
                    $this->logger->info('Added new Credit Card entry to the database');
                    return Response::HTTP_CREATED;
                    //break;
                }
            case '3': {
                    $this->createNote($entryContent, $user);
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

    /**
     * This method is responsible updating an existing Entry
     *
     * @param stdObject $entryContent contains the content that has been passed
     * by the form
     * @param Symfony\Bundle\FrameworkBundle\Controller $user
     * @return type
     */
    public function updateEntry($id, $entryContent, $user)
    {
        switch ($entryContent->category) {
            case '1': {
                    $this->updateLogin($id, $entryContent, $user);
                    $this->logger->info('Updated and existing Login entry to the database');
                    return ['httpStatus' => Response::HTTP_ACCEPTED, 'message' => 'Updated and existing Login information added'];
                    //break;
                }
            case '2': {
                    $this->updateCreditCard($id, $entryContent, $user);
                    $this->logger->info('Updated and existing Credit Card entry to the database');
                    return Response::HTTP_ACCEPTED;
                    //break;
                }
            case '3': {
                    $this->updateNote($id, $entryContent, $user);
                    $this->logger->info('Updated and existing  Note entry to the database');
                    return Response::HTTP_ACCEPTED;
                    //break;
                }
            default: {
                    return Response::HTTP_BAD_REQUEST;
                    //break; 
                }
        }
    }

    /**
     * This method is responsible for creating a new Login Class Category
     *
     * @param stdObject $entryContent contains the content that has been passed
     * by the form
     * @param Symfony\Bundle\FrameworkBundle\Controller $user
     */
    private function createLogin($entryContent, $user)
    {
        $loginContent = new Login();
        $loginContent->setBase($entryContent->siteUsername, $entryContent->sitePasword, $entryContent->siteSitename);

        $this->createContent($entryContent, $loginContent, $user);
    }

    /**
     * This method is responsible for updating a new Login Class Category
     *
     * @param stdObject $entryContent contains the content that has been passed
     * by the form
     * @param Symfony\Bundle\FrameworkBundle\Controller $user
     */
    private function updateLogin($id, $entryContent, $user)
    {
        $loginContent = new Login();
        $loginContent->setBase($entryContent->siteUsername, $entryContent->sitePasword, $entryContent->siteSitename);

        $this->updateContent($id, $entryContent, $loginContent, $user);
    }

    /**
     * This method is responsible for create a new Content and inserting it
     * into the database
     *
     * @param stdObject $entryContent contains the content that has been passed
     * by the form
     * @param UniquePasswordBundle\Category\{Login|CreditCard|Note} $type object to
     * be constructed
     * @param Symfony\Bundle\FrameworkBundle\Controller $user
     */
    private function createContent($entryContent, $type, $user)
    {
        $dateNow = new \DateTime();

        $content = new Content();

        $content->setName($entryContent->name);
        $encodedContent = $type->encode($this->container, $user->getPassword());

        $content->setContent($encodedContent);

        $content->setCategory($this->getCategoryById($entryContent->category));

        $content->setCreated($dateNow);
        $content->setModified($dateNow);

        $this->em->persist($content);
        $this->em->flush();
    }

    /**
     * This method is responsible for updating an existing content
     * into the database
     *
     * @param stdObject $entryContent contains the content that has been passed
     * by the form
     * @param UniquePasswordBundle\Category\{Login|CreditCard|Note} $type object to
     * be constructed
     * @param Symfony\Bundle\FrameworkBundle\Controller $user
     */
    private function updateContent($id, $entryContent, $type, $user)
    {
        $dateNow = new \DateTime();

        $content = $this->em->getRepository('UniquePasswordBundle:Content')->find($id);

        $content->setName($entryContent->name);
        $encodedContent = $type->encode($this->container, $user->getPassword());

        $content->setContent($encodedContent);

        $content->setModified($dateNow);

        $this->em->persist($content);
        $this->em->flush();
    }

    /**
     * This method is responsible for fetching a specific category by it's Id
     *
     * @param int $id The Id of the category
     * @return UniquePasswordBundle\Entity\Content\Category
     */
    private function getCategoryById($id)
    {
        return $this->em->getRepository('UniquePasswordBundle:Category')->find($id);
    }
}
