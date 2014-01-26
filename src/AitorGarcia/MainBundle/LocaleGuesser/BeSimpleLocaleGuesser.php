<?php
/**
 * This file contains the BeSimpleLocaleGuesser class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2013 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\MainBundle\LocaleGuesser;

use Lunetics\LocaleBundle\LocaleGuesser\AbstractLocaleGuesser;
use Lunetics\LocaleBundle\Validator\MetaValidator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Locale Guesser for detecing the locale in BeSimpleI18nRouting routes.
 */
class BeSimpleLocaleGuesser extends AbstractLocaleGuesser
{
    /**
     * @var MetaValidator
     */
    private $metaValidator;

    /**
     * Constructor
     *
     * @param MetaValidator $metaValidator MetaValidator
     */
    public function __construct(MetaValidator $metaValidator)
    {
        $this->metaValidator = $metaValidator;
    }

    /**
     * Method that guess the locale based on the Router parameters
     *
     * @param Request $request
     *
     * @return boolean True if locale is detected, false otherwise
     */
    public function guessLocale(Request $request)
    {
        $localeValidator = $this->metaValidator;
        if ($request->attributes->has('_route'))
        {
            $route = $request->attributes->get('_route');
            $routeParts = explode('.', $route);
            $foundLocale = end($routeParts);

            if ($localeValidator->isAllowed($foundLocale))
            {
                $this->identifiedLocale = $foundLocale;

                return true;
            }
        }

        return false;
    }
}
