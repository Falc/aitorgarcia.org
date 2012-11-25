<?php
/**
 * This file contains the ProjectTranslationType class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Form\Type;

use AitorGarcia\PortfolioBundle\Entity\Technology;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * This form type will be used for the project translation creation/edition forms.
 */
class ProjectTranslationType extends AbstractType
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
            'trim' => true
        ));

        $builder->add('description', 'textarea', array(
            'label' => 'Descripción:',
            'attr'  => array(
                'class'      => 'tinymce',
                'data-theme' => 'advanced'
            )
        ));

        $builder->add('screenshots', 'collection', array(
            'type'          => new ProjectScreenshotType(),
            'by_reference'  => false
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
            'data_class' => 'AitorGarcia\PortfolioBundle\Entity\Project',
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return  string The name of this type.
     */
    public function getName()
    {
        return 'project_translation';
    }
}
