<?php
declare(strict_types = 1);

namespace App\Query\Common;

/**
 * class PaginatedQuery
 */
class PaginatedQuery
{
    public function __construct(public int $skip, public int $take)
    {}

    /**
     * @return int
     */
    public function getTake(): int
    {
        return $this->take;
    }

    /**
     * @return int
     */
    public function getSkip(): int
    {
        return $this->skip;
    }
}