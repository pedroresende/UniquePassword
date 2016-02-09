<?php

namespace UniquePasswordBundle\Tests\Helper;

use UniquePasswordBundle\Helper\MyCrypt;
/**
 * Description of MyCryptTest
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */
class MyCryptTest extends \PHPUnit_Framework_TestCase
{
    private $myCrypt;

    protected function setUp()
    {
        $this->myCrypt = new MyCrypt('This is my L33t Password');
    }

    public function testEncryptDecrypt()
    {
        $textToEncode = 'This is a text';
        $encodedText  = $this->myCrypt->encrypt($textToEncode);
        $decodedText  = $this->myCrypt->descrypt($encodedText);

        $this->assertEquals($textToEncode, $decodedText);
    }
}