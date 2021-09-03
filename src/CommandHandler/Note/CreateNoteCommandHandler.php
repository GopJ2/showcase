<?php
declare(strict_types=1);

namespace App\CommandHandler\Note;

use App\Command\Note\CreateNoteCommand;
use App\Entity\Note;
use App\Event\Note\NoteHasBeenCreatedEvent;
use App\Repository\NoteRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * class CreateNoteCommandHandler
 */
final class CreateNoteCommandHandler implements MessageHandlerInterface
{
    /**
     * @param MessageBusInterface $eventBus
     * @param LoggerInterface     $logger
     * @param NoteRepository      $repository
     */
    public function __construct(
        public MessageBusInterface $eventBus,
        public LoggerInterface $logger,
        public NoteRepository $repository
    ){}

    /**
     * @param CreateNoteCommand $command
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(CreateNoteCommand $command): void
    {
        $note = new Note(
            $command->getId(),
            $command->getUser(),
            $command->getDescription()
        );
        $this->repository->save($note);
        $this->eventBus->dispatch(new NoteHasBeenCreatedEvent($note, $command->getUser()));
    }
}