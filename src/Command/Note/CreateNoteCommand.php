<?php
declare(strict_types = 1);

namespace App\Command\Note;

use App\Entity\User;
use Ramsey\Uuid\UuidInterface;

/**
 * class CreateNoteCommand
 */
final class CreateNoteCommand
{
    private UuidInterface $id;
    private User $user;
    private string $description;

    /**
     * @param UuidInterface $id
     * @param User          $user
     * @param string        $description
     */
    public function __construct(UuidInterface $id, User $user, string $description)
    {
        $this->user = $user;
        $this->description = $description;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}