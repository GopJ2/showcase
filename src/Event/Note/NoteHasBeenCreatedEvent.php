<?php
declare(strict_types = 1);

namespace App\Event\Note;

use App\Entity\Note;
use App\Entity\User;

/**
 * class NoteHasBeenCreatedEvent
 */
final class NoteHasBeenCreatedEvent
{
    public function __construct(
        public Note $note,
        public User $user
    ){}
}