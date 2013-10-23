<?php
/**
 * This file contains the SecurityController class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2013 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Overrides FOSUserBundle\Controller\SecurityController.
 */
class SecurityController extends BaseSecurityController
{
    /**
     * Redirects the user to the index if it is already authenticated. Else, renders the login form.
     */
    public function loginAction()
    {
        $securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY') || $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $request = $this->container->get('request');
            $locale = $request->getSession()->get('lunetics_locale') ?: $this->container->getParameter('locale');

            return new RedirectResponse($this->container->get('router')->generate('index'.'.'.$locale));
        }

        return parent::loginAction();
    }
}
