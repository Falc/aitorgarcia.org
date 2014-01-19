<?php
/**
 * This file contains the CommentType class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Form\Type;

use Exercise\HTMLPurifierBundle\Form\HTMLPurifierTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This form type will be used for the comment edition form.
 */
class CommentType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param   \Symfony\Component\Form\FormBuilderInterface    $builder    The form builder.
     * @param   array                                           $options    The options.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('author', 'text', array(
            'trim'  => true,
            'attr'  => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('email', 'email', array(
            'trim'  => true,
            'attr'  => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('website', 'url', array(
            'trim'  => true,
            'attr'  => array(
                'class' => 'form-control'
            ),
            'required'  => false
        ));

        $body = $builder->create('body', 'textarea', array(
            'attr' => array(
                'class'      => 'tinymce',
                'data-theme' => 'advanced'
            )
        ));

        $body->addViewTransformer(new HTMLPurifierTransformer($options['purifier']));
        $builder->add($body);

        // Honeypot
        $builder->add('subject', 'honeypot');
    }

    /**
     * Sets the default options for this type.
     *
     * @param   \Symfony\Component\OptionsResolver\OptionsResolverInterface  $resolver  The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AitorGarcia\BlogBundle\Entity\Comment'
        ));

        $resolver->setRequired(array(
            'purifier'
        ));

        $resolver->setAllowedTypes(array(
            'purifier' => 'HtmlPurifier'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return  string The name of this type.
     */
    public function getName()
    {
        return 'comment';
    }
}
