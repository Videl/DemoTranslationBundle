<?php

namespace A2lix\DemoTranslationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('slug')
            ->add('translations', 'translations', array(
                'by_reference' => false,
                'locales' => $options['locales']
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'A2lix\DemoTranslationBundle\Entity\Category',
			'locales' => array()
        ));
    }

    public function getName()
    {
        return 'category';
    }
}
