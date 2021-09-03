<?php
declare(strict_types = 1);

namespace App\Command\Account;

use Ramsey\Uuid\UuidInterface;

/**
 * class CreateUserCommand
 */
final class CreateUserCommand
{
    private UuidInterface $id;
    private string $email;
    private string $password;

    /**
     * @param UuidInterface $id
     * @param string        $email
     * @param string        $password
     */
    public function __construct(UuidInterface $id, string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}