<?php
declare(strict_types = 1);

namespace App\CommandHandler\Account;

use App\Command\Account\CreateUserCommand;
use App\Entity\User;
use App\Event\User\UserHasBeenCreatedEvent;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Throwable;

/**
 * class CreateUserCommandHandler
 */
final class CreateUserCommandHandler implements MessageHandlerInterface
{
    /**
     * @param UserRepository $repository
     */
    public function __construct(
        public UserRepository $repository,
        public UserPasswordHasherInterface $passwordHasher,
        public MessageBusInterface $eventBus
    ){}

    /**
     * @param CreateUserCommand $command
     */
    public function __invoke(CreateUserCommand $command)
    {
        try {
            $user = new User(
                $command->getEmail()
            );

            $hashedPassword = $this->passwordHasher->hashPassword($user, $command->getPassword());

            $user->setPassword($hashedPassword);
            $this->repository->save($user);

            $this->eventBus->dispatch(new UserHasBeenCreatedEvent($user));
        }catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}