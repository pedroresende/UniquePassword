<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use UniquePasswordBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160210110548 extends AbstractMigration implements ContainerAwareInterface {

    private $container;
    
    private $em;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager('default');
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) {
        $arryOfCategories = array(
            array('name' => 'Login', 'icon' => 'fa-sign-in'),
            array('name' => 'Credit Card', 'icon' => 'fa-credit-card'),
            array('name' => 'Note', 'icon' => 'fa-sticky-note-o'),
            array('name' => 'ssh', 'icon' => 'fa-terminal')
        );
        foreach ($arryOfCategories as $category) {
            $newCategory = new Category;

            $newCategory->setName($category['name']);
            $newCategory->setIcon($category['icon']);

            $this->em->persist($newCategory);
            $this->em->flush($newCategory);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {
        $categories = $this->container->get('doctrine')->getRepository('UniquePasswordBundle:Category')->findAll();
        foreach ($categories as $category) {
            $this->em->remove($category);
            $this->em->flush($category);
        }
    }

}
