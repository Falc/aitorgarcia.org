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
            'label' => 'Descripción:'
        ));

        $builder->add('technologies', 'entity', array(
            'label' => 'Tecnologías:',
            'class' => 'AitorGarcia\PortfolioBundle\Entity\Technology',
            'property' => 'name',
            'multiple' => true
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
