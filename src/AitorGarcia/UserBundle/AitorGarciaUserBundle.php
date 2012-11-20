<?php

namespace AitorGarcia\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AitorGarciaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
