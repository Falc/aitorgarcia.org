<?php

namespace AitorGarcia\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'Nombre:',
            'trim'  => true
        ));

        $builder->add('email', 'email', array(
            'label' => 'Email:',
            'trim'  => true
        ));

        $builder->add('subject', 'text', array(
            'label' => 'Asunto:',
            'trim'  => true
        ));

        $builder->add('body', 'textarea', array(
            'label' => 'Mensaje:',
            'trim'  => true
        ));
    }

    public function getName()
    {
        return 'contact';
    }
}
