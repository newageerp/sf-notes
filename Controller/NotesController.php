<?php

namespace Newageerp\SfNotes\Controller;

use Newageerp\SfBaseEntity\Controller\OaBaseController;
use Newageerp\SfNotes\Messenger\NotesReadAllMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @Route (path="/app/nae-core/plugins/notes")
 */
class NotesController extends OaBaseController
{
    /**
     * @Route (path="/readAllMessages", methods={"POST"})
     * @OA\Post (operationId="NAENotesReadAll")
     */
    public function readAllMessages(Request $request, MessageBusInterface $bus,)
    {
        $request = $this->transformJsonBody($request);

        if (!($user = $this->findUser($request))) {
            throw new \Exception('Invalid user');
        }

        $bus->dispatch(new NotesReadAllMessage($user->getId()));

        return $this->json(['success' => 1]);
    }
}