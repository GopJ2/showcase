<?php
declare(strict_types = 1);

namespace App\Controller\Note;

use App\Command\Note\CreateNoteCommand;
use App\Query\Note\GetPaginatedNotesByUserQuery;
use App\Request\Note\CreateNoteRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class ApiNoteController extends AbstractFOSRestController
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $messageBus
     * @param LoggerInterface     $logger
     */
    public function __construct(
        MessageBusInterface $messageBus,
        public LoggerInterface $logger
    ) {
        $this->messageBus = $messageBus;
    }

    /**
     * @Rest\Post("/api/notes", name="api_create_note")
     * @ParamConverter("request", converter="fos_rest.request_body")
     */
    public function createNote(CreateNoteRequest $request)
    {
        try {
            $id = Uuid::uuid4();
            $noteCommand = new CreateNoteCommand(
                $id,
                $this->getUser(),
                $request->description
            );

            $this->messageBus->dispatch($noteCommand);

            return new JsonResponse($id, Response::HTTP_OK);
        }catch (Throwable $exception) {
            return new JsonResponse('Error while note creation', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/notes", name="api_get_users_note")
     */
    public function getNotesByUser(Request $request): JsonResponse
    {
        try {
            $skip = (int) $request->query->get('skip', 0);
            $take = (int) $request->query->get('take', 10);

            $query = new GetPaginatedNotesByUserQuery(
                $this->getUser(),
                $skip,
                $take
            );

            $result = $this->handle($query);

            return new JsonResponse($result);
        } catch (Throwable $exception) {
            return new JsonResponse('Error while getting notes', Response::HTTP_BAD_REQUEST);
        }
    }
}