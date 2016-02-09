<?php

namespace OverrideAdminThemeBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use OverrideAdminThemeBundle\Model\UserModel;
use UniquePasswordBundle\Entity\User;

/**
 * Description of MyShowUserListener
 *
 * @author pedroresende
 */
class MyShowUserListener
{

    public function onShowUser(ShowUserEvent $event)
    {

        $user = $this->getUser();
        $event->setUser($user);
    }

    protected function getUser()
    {
        $userModel = new UserModel();
        return $userModel;
    }

}
