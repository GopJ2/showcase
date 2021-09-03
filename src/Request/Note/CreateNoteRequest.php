<?php

namespace App\Request\Note;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateNoteRequest
 */
final class CreateNoteRequest
{
    /**
     * @Serializer\Type("string")
     *
     * @Assert\NotNull(message="Description can't be null")
     * @Assert\NotBlank(message="Description can't be empty")
     */
    public string $description;
}