<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\PasswordTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class PassChangeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', PasswordType::class, array('attr' => array('placeholder' => 'Mot de passe actuel'),
                'label' => 'Mot de passe actuel',
                'constraints' => array(
                    new NotBlank(array("message" => "Entrez votre mot de passe")),
                )
            ))
            ->add('newPassword', PasswordType::class, array(
                'label' => 'Nouveau mot de passe',
                'constraints' => array(
                    new NotBlank(array("message" => "Entrez un nouveau mot de passe")),
                )
            ))
            ->add('confirmPassword', PasswordType::class, array(
                'label' => 'Confirmation du mot de passe',
                'constraints' => array(
                    new NotBlank(array("message" => "Confirmer le nouveau mot de passe")),
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'changepassword_form';
    }
}
