<?php


namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends BaseAdminController
{
    /** @var UserPasswordEncoderInterface $passEncoder */
    private $passEncoder;

    /**
     * UserController constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passEncoder = $passwordEncoder;
    }

    /**
     * @param User $entity
     */
    protected function persistEntity($entity): void
    {
        $password = $this->passEncoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($password);

        parent::persistEntity($entity);
    }

    /**
     * @param User $entity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function updateEntity($entity): void
    {
        $password = $this->passEncoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($password);

        $this->em->flush();
    }
}