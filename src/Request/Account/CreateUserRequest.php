<?php
declare(strict_types = 1);

namespace App\Request\Account;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateUserRequest
 */
final class CreateUserRequest
{
    /**
     * @Serializer\Type("string")
     *
     * @Assert\Email(message="The email is incorrect")
     * @Assert\NotNull(message="Email can't be null")
     * @Assert\NotBlank(message="Email can't be empty")
     */
    public string $email;

    /**
     * @Serializer\Type("string")
     *
     * @Assert\NotNull(message="Password can't be null")
     * @Assert\NotBlank(message="Password can't be empty")
     */
    public string $password;
}