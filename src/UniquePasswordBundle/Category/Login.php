<?php

namespace UniquePasswordBundle\Category;

/**
 * Description of Login
 *
 * @author Pedro Resende <pedroresende@mail.resende.biz>
 */
class Login implements CategoryInterface
{

    private $user;
    private $password;
    private $site;
    
    public function __construct()
    {
        
    }
 
    public function setBase($user, $password, $site)
    {
        $this->user = $user;
        $this->password = $password;
        $this->site = $site;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setSite($site)
    {
        $this->site = $site;
    }

    public function decode($contentEncoded, $container, $password)
    {
        $myCrypt = $container->get('unique_password.mycrypt');
        $myCrypt->setPassword($password);
        $decodedText = $myCrypt->descrypt($contentEncoded);

        return $decodedText;
    }

    public function encode($container, $password)
    {
        $object = ['user' => $this->user, 'password' => $this->password, 'site' => $this->site];

        $myCrypt = $container->get('unique_password.mycrypt');
        $myCrypt->setPassword($password);
        $encodedText = $myCrypt->encrypt(json_encode($object));

        return $encodedText;
    }

}
