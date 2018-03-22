<?php

namespace App\Controller\Admin\EasyAdmin;


use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AdminController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $entity
     */
    protected function preUpdateEntity($entity)
    {
        if (!$entity instanceof User) {
            return;
        }

        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPassword()
        );

        $entity->setPassword($encoded);
    }
}