<?php
namespace Domia\User;
require 'vendor/autoload.php';
class UserId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}