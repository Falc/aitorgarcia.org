<?php

namespace AitorGarcia\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TechnologyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'trim'  => true
        ));
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AitorGarcia\PortfolioBundle\Entity\Technology'
        );
    }

    public function getName()
    {
        return 'technology';
    }
}
