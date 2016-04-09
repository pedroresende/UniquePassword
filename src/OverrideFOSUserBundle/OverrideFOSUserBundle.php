<?php

namespace OverrideFOSUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OverrideFOSUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
