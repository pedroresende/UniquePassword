<?php

namespace UniquePasswordBundle\Tests\Helper;

use UniquePasswordBundle\Helper\MyCrypt;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of MyCryptTest
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */
class MyCryptTest extends KernelTestCase
{

    private $container;
    private $myCrypt;

    protected function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->myCrypt = $this->container->get('unique_password.mycrypt');
        $this->myCrypt->setPassword('This is my L33t Password');
    }

    public function testEncryptDecrypt()
    {
        $textToEncode = 'This is a text';

        $this->myCrypt->setPassword('This is my L33t Password');
        $encodedText = $this->myCrypt->encrypt($textToEncode);

        $this->myCrypt->setPassword('This is my L33t Password');
        $decodedText = $this->myCrypt->descrypt($encodedText);

        $this->assertEquals($textToEncode, $decodedText);
    }

    public function testEncryptDecryptArray()
    {
        $object = ['user' => 'Pedro', 'password' => 'Something', 'site' => 'http'];

        $this->myCrypt->setPassword('This is my L33t Password');
        $encodedText = $this->myCrypt->encrypt(json_encode($object));

        $this->myCrypt->setPassword('This is my L33t Password');
        $decodedText = json_decode($this->myCrypt->descrypt($encodedText), true);

        $this->assertEquals($object, $decodedText);
    }

}
