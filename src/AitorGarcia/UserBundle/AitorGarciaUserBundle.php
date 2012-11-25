<?php
/**
 * This file contains the UserBundle.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * UserBundle inherits from FOS UserBundle.
 */
class AitorGarciaUserBundle extends Bundle
{
    /**
     * Get the parent bundle name.
     *
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
