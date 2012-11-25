<?php
/**
 * This file contains the EnquiryType class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * This form type will be used for the contact/enquiry form.
 */
class EnquiryType extends AbstractType
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

        $builder->add('email', 'email', array(
            'trim'  => true
        ));

        $builder->add('subject', 'text', array(
            'trim'  => true
        ));

        $builder->add('body', 'textarea', array(
            'trim'  => true
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return  string The name of this type.
     */
    public function getName()
    {
        return 'contact';
    }
}
