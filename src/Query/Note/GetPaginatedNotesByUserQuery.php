<?php
declare(strict_types = 1);

namespace App\Query\Note;

use App\Entity\User;
use App\Query\Common\PaginatedQuery;

/**
 * class GetPaginatedNotesByUserQuery
 */
final class GetPaginatedNotesByUserQuery extends PaginatedQuery
{
    public function __construct(public User $user, int $skip, int $take)
    {
        parent::__construct($skip, $take);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}