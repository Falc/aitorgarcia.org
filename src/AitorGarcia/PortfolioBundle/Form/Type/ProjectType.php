<?php

namespace AitorGarcia\PortfolioBundle\Form\Type;

use AitorGarcia\PortfolioBundle\Entity\Technology;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'Nombre:',
            'trim'  => true
        ));

        $builder->add('description', 'textarea', array(
            'label' => 'Descripción:',
            'attr'  => array(
                'class'      => 'tinymce',
                'data-theme' => 'advanced'
            )
        ));

        $builder->add('client', 'text', array(
            'label'     => 'Cliente:',
            'required'  => false,
            'trim'      => true
        ));

        $builder->add('link', 'text', array(
            'label' => 'Enlace al proyecto:',
            'trim'  => true
        ));

        $builder->add('sourceLink', 'text', array(
            'label'     => 'Enlace al código fuente:',
            'required'  => false,
            'trim'      => true
        ));

        $builder->add('technologies', 'entity', array(
            'label'     => 'Tecnologías:',
            'class'     => 'AitorGarcia\PortfolioBundle\Entity\Technology',
            'property'  => 'name',
            'multiple'  => true
        ));

        $builder->add('screenshots', 'collection', array(
            'type'          => new ProjectScreenshotType(),
            'allow_add'     => true,
            'allow_delete'  => true,
            'by_reference'  => false,
            'required'      => false
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AitorGarcia\PortfolioBundle\Entity\Project',
        );
    }

    public function getName()
    {
        return 'project';
    }
}
