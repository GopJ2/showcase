<?php
declare(strict_types = 1);

namespace App\QueryHandler;

use App\Query\Note\GetPaginatedNotesByUserQuery;
use App\Repository\NoteRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * class GetPaginatedNotesByUserQueryHandler
 */
final class GetPaginatedNotesByUserQueryHandler implements MessageHandlerInterface
{
    /**
     * @param NoteRepository $repository
     */
    public function __construct(public NoteRepository $repository)
    {
    }

    /**
     * @param GetPaginatedNotesByUserQuery $query
     *
     * @return array
     */
    public function __invoke(GetPaginatedNotesByUserQuery $query): array
    {
        return $this->repository->getNotesByUserPaginated($query);
    }
}