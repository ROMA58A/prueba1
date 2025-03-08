<?php
namespace Domia\User;
require 'vendor/autoload.php';
class Name
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException("El nombre no puede estar vacío");
        }
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
} 