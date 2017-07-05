<?php

namespace SoftUniBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class findByForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('findCriteria', ChoiceType::class,
                [
                    'choices'  =>
                        [
                           'slug' => 'slug',
                            'title' => 'title',
                            'description' => 'description',
                        ],
                    'multiple' => false,
                    'label' => false,
                ])
            ->add('findField', TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'type key phrase'
                    ]
                ]
            )
            ->add('findIt   ', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'softuniBundle-findBy-form';
    }
}
