<?php

require 'vendor/autoload.php';
namespace Domia\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findByEmail(string $email): ?User;
    public function findById(UserId $id): ?User;
}
