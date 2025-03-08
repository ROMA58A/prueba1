<?php
namespace Infrastructure\User;
require 'vendor/autoload.php';
use Domia\User\UserRepositoryInterface;
use Domia\User\User;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function findById(UserId $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }
}