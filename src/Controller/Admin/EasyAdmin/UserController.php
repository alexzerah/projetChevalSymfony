<?php

namespace App\Controller\Admin\EasyAdmin;


use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AdminController
{
    private $passwordEncoder;

    /**
     * @param User $entity
     */
    protected function prePersistEntity($entity)
    {
        $this->encryptAction($entity);
    }

    /**
     * @param User $entity
     */
    protected function preUpdateEntity($entity)
    {
        $this->encryptAction($entity);
    }


    protected function encryptAction($entity) {
        if (!$entity instanceof User) {
            return;
        }

        if($entity->getPlainPassword() == null){
            return;
        }

        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPlainPassword()
        );

        $entity->setPassword($encoded);
        $entity->setPlainPassword(null);

    }

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
}