<?php

namespace UniquePasswordBundle\Helper;

interface MyCryptInterface
{

    /**
     * This method will instanciate the class
     */
    public function __construct();

    /**
     * This method is responsible for setting the password to encode or decode
     * the content
     * 
     * @param string $password password to encrypt the content
     */
    public function setPassword($password);

    /**
     * This method is responsible for encoding a given string into AES-256 bit
     * encryptition
     *
     * @param string $toEncode The content to be encoded
     */
    public function encrypt($toEncode);

    /**
     * This method is responsible for decoding a given encoded string in AES-256
     * bit encryption
     *
     * @param string $encoded The content to be decoded
     */
    public function descrypt($encoded);
}