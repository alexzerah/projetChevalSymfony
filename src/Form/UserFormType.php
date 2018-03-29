<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->setAction('profil')
            ->add('avatarFile',VichImageType::class, array(
                'label' => 'Photo de profil',
                'required' => false,
                'allow_delete' => false,
                'delete_label' => 'Supprimer ?',
                'download_link' => false
            ))
            ->add('firstName',TextType::class, array(
                'label'=>'Prénom'
            ))
            ->add('lastName',TextType::class, array(
                'label'=>'Nom'
            ))
            ->add('email',EmailType::class, array(
                'label'=>'Adresse e-Mail'
            ))
            ->add('followCategoryExhibit', CheckboxType::class, array(
                'label' => "S'abonner aux soirées",
                'required' => false
            ))
            ->add('followCategoryParty', CheckboxType::class, array(
                'label' => "S'abonner aux expositions",
                'required' => false
            ))
            ->add('followCategoryWeekend', CheckboxType::class, array(
                'label' => "S'abonner aux weekends",
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
