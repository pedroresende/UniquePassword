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
        $encodedText  = $this->myCrypt->encrypt($textToEncode);
        $decodedText  = $this->myCrypt->descrypt($encodedText);

        $this->assertEquals($textToEncode, $decodedText);
    }
}