<?php
/**
 * This file contains the ProjectType class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Form\Type;

use AitorGarcia\PortfolioBundle\Entity\Technology;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This form type will be used for the project creation/edition forms.
 */
class ProjectType extends AbstractType
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

        $builder->add('description', 'textarea', array(
            'attr'  => array(
                'class'      => 'tinymce form-control',
                'data-theme' => 'advanced'
            )
        ));

        $builder->add('client', 'text', array(
            'required'  => false,
            'trim'      => true,
            'attr'  => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('link', 'text', array(
            'trim'  => true,
            'attr'  => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('sourceLink', 'text', array(
            'required'  => false,
            'trim'      => true,
            'attr'  => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('technologies', 'entity', array(
            'class'     => 'AitorGarcia\PortfolioBundle\Entity\Technology',
            'property'  => 'name',
            'multiple'  => true,
            'attr'      => array(
                'size'  => 6,
                'class' => 'form-control'
            ),
            'required'  => false
        ));

        $builder->add('screenshots', 'collection', array(
            'type'          => new ProjectScreenshotType(),
            'allow_add'     => true,
            'allow_delete'  => true,
            'by_reference'  => false,
            'required'      => false
        ));
    }

    /**
     * Sets the default options for this type.
     *
     * @param   \Symfony\Component\OptionsResolver\OptionsResolverInterface  $resolver  The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AitorGarcia\PortfolioBundle\Entity\Project'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return  string The name of this type.
     */
    public function getName()
    {
        return 'project';
    }
}
