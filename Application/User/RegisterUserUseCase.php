<?php
namespace Application\User;

use Domia\User\UserRepositoryInterface;
use Domia\User\User;
use Domia\User\Email;
use Domia\User\Password;
use Domia\User\UserId;
use Domia\User\Name;
use InvalidArgumentException;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $name, string $password): void
    {
        // Validación de email y contraseña
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email inválido');
        }

        if (strlen($password) < 8) {
            throw new InvalidArgumentException('La contraseña debe tener al menos 8 caracteres');
        }

        // Verificar si el usuario ya existe
        $existingUser = $this->userRepository->findByEmail($email);
        if ($existingUser) {
            throw new InvalidArgumentException('El usuario ya existe');
        }

        // Crear y guardar el nuevo usuario
        $user = new User(
            new UserId(uniqid()), // Generación de ID único
            new Name($name),
            new Email($email),
            new Password($password)
        );

        $this->userRepository->save($user);
    }
}