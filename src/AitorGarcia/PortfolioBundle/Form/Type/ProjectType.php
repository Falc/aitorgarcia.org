<?php
/**
 * This file contains the ProjectType class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2012-2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Form\Type;

use AitorGarcia\PortfolioBundle\Entity\Technology;
use AitorGarcia\PortfolioBundle\Form\DataTransformer\TechnologiesToCSVTransformer;
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
                'class'      => 'form-control tinymce',
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

        $technologies = $builder->create('technologies', 'text', array(
            'attr'  => array(
                'class'         => 'form-control typeahead',
                'data-source'   => json_encode(array_map('htmlspecialchars', $options['technologies'])),
                'autocomplete'  => 'off'
            ),
            'required'  => false
        ));

        $technologies->addModelTransformer(new TechnologiesToCSVTransformer($options['em']));

        $builder->add($technologies);

        $builder->add('screenshots', 'collection', array(
            'type'          => new ProjectScreenshotType(),
            'allow_add'     => true,
            'allow_delete'  => true,
            'by_reference'  => false,
            'options'       => array(
                'required'  => false
            )
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
            'data_class'         => 'AitorGarcia\PortfolioBundle\Entity\Project',
            'cascade_validation' => true
        ));

        $resolver->setRequired(array(
            'em',
            'technologies'
        ));

        $resolver->setAllowedTypes(array(
            'em'            => 'Doctrine\Common\Persistence\ObjectManager',
            'technologies'  => 'array'
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
