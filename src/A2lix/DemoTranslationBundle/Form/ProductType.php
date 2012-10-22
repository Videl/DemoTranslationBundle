<?php

namespace A2lix\DemoTranslationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use A2lix\DemoTranslationBundle\Form\CategoryType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'Title En'
            ))
            ->add('description', null, array(
                'label' => 'Description En'
            ))
            ->add('translations', 'a2lix_translations', array(
                'fields' => array(
                    'description' => array(
                        'label' => "Desc",
                        'type' => "text"
                    )
                )
            ))
            ->add('categories', 'collection', array(
                'type' => new CategoryType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'options' => array(
                    'data_class' => 'A2lix\DemoTranslationBundle\Entity\Category'
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'A2lix\DemoTranslationBundle\Entity\Product',
            'translation_domain' => 'forms'
        ));
    }

    public function getName()
    {
        return 'product';
    }
}
