<?php
namespace Domia\User;
require 'vendor/autoload.php';

use InvalidArgumentException;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
final class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    private UserId $id;

    #[ORM\Column(type: 'string', length: 255)]
    private Name $name;

    #[ORM\Column(type: 'string', unique: true, length: 255)]
    private Email $email;

    #[ORM\Column(type: 'string', length: 255)]
    private Password $password;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function __construct(UserId $id, Name $name, Email $email, Password $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new DateTimeImmutable();
    }
}