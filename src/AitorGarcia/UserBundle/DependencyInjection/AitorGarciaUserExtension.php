<?php
/**
 * This file contains the UserExtension class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012, 2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}.
 */
class AitorGarciaUserExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $configs     An array of configuration values.
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container   A ContainerBuilder instance.
     *
     * @throws InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
    }
}
