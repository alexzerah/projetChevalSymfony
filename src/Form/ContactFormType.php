<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array('placeholder' => 'Nom'),
                'label' => 'Nom',
                'constraints' => array(
                    new NotBlank(array("message" => "Entrez votre nom")),
                )
            ))
            ->add('subject', TextType::class, array('attr' => array('placeholder' => 'Objet'),
                'label' => 'Objet',
                'constraints' => array(
                    new NotBlank(array("message" => "Entrez un objet")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Email'),
                'label' => 'Email',
                'constraints' => array(
                    new NotBlank(array("message" => "Entrez un mail valide")),
                    new Email(array("message" => "mail invalide")),
                )
            ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Dites coucou !'),
                'label' => 'Message',
                'constraints' => array(
                    new NotBlank(array("message" => "Dites nous quelque chose")),
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
        return 'contact_form';
    }
}
