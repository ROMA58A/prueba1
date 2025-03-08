<?php
require 'vendor/autoload.php';
namespace Domia\User;

use InvalidArgumentException;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        // Log de inicio de la validación
        echo "Iniciando la validación de la contraseña...\n";

        // Validación de la longitud de la contraseña
        if (strlen($password) < 1) {
            // Log de error si la contraseña no tiene la longitud suficiente
            echo "Error: La contraseña debe tener al menos 8 caracteres.\n";
            throw new InvalidArgumentException("La contraseña debe tener al menos 8 caracteres");
        }

        // Log de éxito si la contraseña es válida
        echo "Contraseña válida: " . $password . "\n";

        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
