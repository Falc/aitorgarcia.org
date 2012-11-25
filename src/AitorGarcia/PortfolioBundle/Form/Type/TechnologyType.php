<?php
/**
 * This file contains the TechnologyType class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * This form type will be used for the technology creation/edition forms.
 */
class TechnologyType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param   \Symfony\Component\Form\FormBuilderInterface    $builder    The form builder.
     * @param   array                                           $options    The options.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'trim'  => true
        ));
    }

    /**
     * Returns the default options for this type.
     *
     * @param   array   $options
     * @return  array   The default options.
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AitorGarcia\PortfolioBundle\Entity\Technology'
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return  string The name of this type.
     */
    public function getName()
    {
        return 'technology';
    }
}
