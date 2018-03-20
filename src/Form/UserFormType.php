<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class, array(
                'label'=>'Prénom')
            )
            ->add('lastName',TextType::class, array(
                    'label'=>'Nom')
            )
            ->add('email',EmailType::class, array(
                    'label'=>'Adresse e-Mail')
            )
            ->add('exhibit', CheckboxType::class, array(
                'required' => false
            ))
            ->add('party', CheckboxType::class, array(
                'required' => false
            ))
            ->add('weekend', CheckboxType::class, array(
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\User'
        ]);
    }
}
