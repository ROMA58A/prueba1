<?php
namespace Infrastructure\Controller;
require 'vendor/autoload.php';
use Application\User\RegisterUserUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    #[Route('/register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? '';
        $name = $data['name'] ?? '';
        $password = $data['password'] ?? '';

        try {
            $this->registerUserUseCase->execute($email, $name, $password);
            return new Response('Usuario creado exitosamente', Response::HTTP_CREATED);
        } catch (InvalidArgumentException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}