<?php

namespace OverrideAdminThemeBundle\Model;

use Avanzu\AdminThemeBundle\Model\UserInterface as ThemeUser;

/**
 * Description of UserModel
 *
 * @author pedroresende
 */
class UserModel implements ThemeUser
{

    public function getAvatar()
    {
        return 'http://www.gravatar.com/avatar/12bcda91454077999dcfc43ea294e9fb?d=http%3A%2F%2Fwww.gravatar.com%2Favatar%2F00000000000000000000000000000000%3Fd%3Dmm%26s%3D70&s=70';
    }

    public function getIdentifier()
    {
        return 'unique';
    }

    public function getMemberSince()
    {
        return '10-04-1980';
    }

    public function getName()
    {
        return 'Pedro Resende';
    }

    public function getTitle()
    {
        return 'Sir';
    }

    public function getUsername()
    {
        return 'pedroresende';
    }

    public function isOnline()
    {
        return true;
    }

}
