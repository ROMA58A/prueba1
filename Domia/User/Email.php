<?php
require 'vendor/autoload.php';
namespace Domia\User;

use InvalidArgumentException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        // Log de inicio de la validación
        echo "Iniciando la validación del email: " . $email . "\n";

        // Validación del email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Log del error si el email no es válido
            echo "Email no válido: " . $email . "\n";
            throw new InvalidArgumentException("El email no es válido");
        }

        // Log del éxito de la validación
        echo "Email válido: " . $email . "\n";

        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}