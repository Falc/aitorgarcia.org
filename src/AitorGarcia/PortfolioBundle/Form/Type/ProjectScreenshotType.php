<?php

namespace AitorGarcia\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectScreenshotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'trim'  => true
        ));

        $builder->add('file', 'file', array(
            'attr' => array(
                'accept' => 'image/*'
            )
        ));

        $builder->add('path', 'hidden');
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AitorGarcia\PortfolioBundle\Entity\ProjectScreenshot'
        );
    }

    public function getName()
    {
        return 'projectscreenshot';
    }
}
