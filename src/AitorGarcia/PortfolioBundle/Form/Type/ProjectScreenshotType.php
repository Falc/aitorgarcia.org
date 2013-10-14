<?php
/**
 * This file contains the ProjectScreenshotType class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This form type will be used for the project screenshot creation/edition forms.
 *
 * It is included in the ProjectType.
 */
class ProjectScreenshotType extends AbstractType
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
            'trim'  => true,
            'attr'  => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('file', 'file', array(
            'attr' => array(
                'accept' => 'image/*'
            )
        ));

        $builder->add('path', 'hidden');
        $builder->add('weight', 'hidden');
    }

    /**
     * Sets the default options for this type.
     *
     * @param   \Symfony\Component\OptionsResolver\OptionsResolverInterface  $resolver  The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AitorGarcia\PortfolioBundle\Entity\ProjectScreenshot'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return  string The name of this type.
     */
    public function getName()
    {
        return 'projectscreenshot';
    }
}
