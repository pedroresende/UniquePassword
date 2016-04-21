<?php

namespace UniquePasswordBundle\Helper;

use UniquePasswordBundle\Helper\MyCryptInterface;

/**
 * Description of MyCrypt
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */
class MyCrypt implements MyCryptInterface
{

    /**
     *
     * @var string contains the password_hard in bcrypt
     */
    private $key;

    /**
     * This method will instanciate the class
     *
     */
    public function __construct()
    {
        
    }

    /**
     * This method is responsible for setting the password for the encryption
     *
     * @param string $password password to encrypt the content
     */
    public function setPassword($password)
    {
        $this->key = hash('sha512', $password, true);
    }

    /**
     * This method is responsible for encoding a given string into AES-256 bit
     * encryptition
     *
     * @param string $toEncode The content to be encoded
     */
    public function encrypt($toEncode)
    {
        return base64_encode(
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256,
                substr($this->key, 32),
                $toEncode,
                MCRYPT_MODE_ECB,
                $this->iv()
            )
        );
    }

    /**
     * This method is responsible for decoding a given encoded string in AES-256
     * bit encryption
     *
     * @param string $encoded The content to be decoded
     */
    public function descrypt($encoded)
    {
        $decoded = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_256,
            substr($this->key, 32),
            base64_decode($encoded),
            MCRYPT_MODE_ECB,
            $this->iv()
        );

        return trim($decoded);
    }

    /**
     * This method is responsible for creating an initialization vector (IV)
     * from a random source
     */
    private function iv()
    {
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

        return mcrypt_create_iv($iv_size, MCRYPT_RAND);
    }
}
