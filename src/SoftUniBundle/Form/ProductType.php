<?php

namespace SoftUniBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', TextType::class, ['required' => false])
            ->add('title', TextType::class, ['required' => false])
            ->add('subtitle', TextType::class, ['required' => false])
            ->add('description', TextType::class, ['required' => false])
            ->add('price', TextType::class, ['required' => false])
            ->add('rank', TextType::class, ['required' => false])
            ->add('picture', FileType::class, [
                'data_class' => null,
                'label' => 'upload img',
                'required' => false
                ])
            ->add('productCategories', EntityType::class, [
                'class' => 'SoftUniBundle\Entity\ProductCategory',
                'multiple' => true,
                'required' => false
                ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SoftUniBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'softunibundle_product';
    }


}
