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

    public function __construct($user, $password, $site)
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

    public function decode()
    {
        return json_decode($this);
    }

    public function encode()
    {
        return json_encode($this);
    }

}
