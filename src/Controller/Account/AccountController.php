<?php
declare(strict_types = 1);

namespace App\Controller\Account;

use App\Command\Account\CreateUserCommand;
use App\Request\Account\CreateUserRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Throwable;

/**
 * class AccountController
 */
final class AccountController extends AbstractFOSRestController
{
    /**
     * @param MessageBusInterface $bus
     * @param ValidatorInterface  $validator
     */
    public function __construct(public MessageBusInterface $bus, public ValidatorInterface $validator)
    {
    }

    /**
     * @Rest\Post("/api/users/create", name="api_create_user")
     * @ParamConverter("request", converter="fos_rest.request_body")
     */
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        $errors = $this->validator->validate($request);

        if ($errors->count()) {
            return new JsonResponse($errors[0]->getMessage(), 400);
        }

        try {
            $uuid = Uuid::uuid4();
            $command = new CreateUserCommand(
                $uuid,
                $request->email,
                $request->password
            );

            $this->bus->dispatch($command);

            return new JsonResponse($uuid->toString(), 200);
        } catch (Throwable $e) {
            return new JsonResponse("Error while user creation", 400);
        }
    }
}