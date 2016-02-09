<?php

namespace OverrideAdminThemeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OverrideAdminThemeBundle extends Bundle
{

    public function getParent()
    {
        return 'AvanzuAdminThemeBundle';
    }

}
