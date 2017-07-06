<?php

namespace SoftUniBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindProductByType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $criteria =
            [
                'slug' => 'slug',
                'title' => 'title',
                'description' => 'description',
                'picture' => 'picture',
                'subtitle' => 'subtitle',
            ];


        $builder
            ->add('findField', TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'type key phrase'
                    ],
                    'required' => false
                ]
            )
            ->add('findCriteria', ChoiceType::class,
                [
                    'choices'  => $criteria,
                        'data' => $criteria,
                    'multiple' => true,
                    'expanded' => true,
                    'label' => false,
                    'required' => false,
                ])

            ->add('findIt   ', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'softuniBundle-findProduct';
    }
}
