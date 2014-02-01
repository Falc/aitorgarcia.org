<?php
/**
 * This file contains the PostType class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Form\Type;

use AitorGarcia\BlogBundle\Entity\Tag;
use AitorGarcia\BlogBundle\Form\DataTransformer\TagsToCSVTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This form type will be used for the post creation/edition forms.
 */
class PostType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param   \Symfony\Component\Form\FormBuilderInterface    $builder    The form builder.
     * @param   array                                           $options    The options.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
            'trim'  => true,
            'attr'  => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('body', 'textarea', array(
            'attr'  => array(
                'class'      => 'form-control tinymce',
                'data-theme' => 'advanced'
            )
        ));

        $tags = $builder->create('tags', 'text', array(
            'attr'  => array(
                'class'         => 'form-control typeahead',
                'data-source'   => json_encode(array_map('htmlspecialchars', $options['tags'])),
                'autocomplete'  => 'off'
            ),
            'required'  => false
        ));

        $tags->addModelTransformer(new TagsToCSVTransformer($options['em']));

        $builder->add($tags);

        $builder->add('isPublished', 'choice', array(
            'attr' => array(
                'class' => 'form-control form-dropdown'
            ),
            'choices' => array(
                false   => 'posts.status.draft',
                true    => 'posts.status.published'
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
            'data_class'         => 'AitorGarcia\BlogBundle\Entity\Post',
            'cascade_validation' => true
        ));

        $resolver->setRequired(array(
            'em',
            'tags'
        ));

        $resolver->setAllowedTypes(array(
            'em'    => 'Doctrine\Common\Persistence\ObjectManager',
            'tags'  => 'array'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return  string The name of this type.
     */
    public function getName()
    {
        return 'post';
    }
}
