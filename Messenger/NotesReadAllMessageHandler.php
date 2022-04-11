<?php

namespace Newageerp\SfNotes\Messenger;

use Doctrine\ORM\EntityManagerInterface;
use Newageerp\SfAuth\Service\AuthService;
use Newageerp\SfSocket\Event\SocketSendPoolEvent;
use Newageerp\SfUservice\Service\UService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class NotesReadAllMessageHandler
{
    protected EntityManagerInterface $em;

    protected LoggerInterface $ajLogger;

    protected EventDispatcherInterface $eventDispatcher;

    protected UService $uservice;

    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $ajLogger,
        EventDispatcherInterface $eventDispatcher,
        UService $uservice,
    ) {
        $this->em = $em;
        $this->ajLogger = $ajLogger;
        $this->eventDispatcher = $eventDispatcher;
        $this->uservice = $uservice;
    }

    public function __invoke(NotesReadAllMessage $message)
    {
        $noteClass = 'App\\Entity\\Note';
        $userClass = 'App\\Entity\\User';

        $notesRepository = $this->em->getRepository($noteClass);
        $userRepository = $this->em->getRepository($userClass);

        $userId = $message->getUserId();
        $user = $userRepository->find($userId);

        AuthService::getInstance()->setUser($user);

        $filter = [
            [
                "and" => [
                    [
                        "or" => [
                            ['i.notify', 'JSON_CONTAINS', (string)$userId, true],
                            ['i.notify', 'JSON_CONTAINS', '"' . ($user->getPermissionGroup() ? $user->getPermissionGroup() : '-') . '"', true]
                        ]
                    ],
                    ['i.notifyAccept', 'JSON_NOT_CONTAINS', (string)$userId, true]
                ],
            ]
        ];
        $notes = $this->uservice->getListDataForSchema(
            'note',
            1,
            10000000,
            ['id'],
            $filter,
            [],
            [
                [
                    'key' => 'i.id',
                    'value' => 'ASC',
                ]
            ],
            []
        );

        foreach ($notes['data'] as $noteEl) {
            $note = $notesRepository->find($noteEl['id']);
            $note->setNotifyAccept(
                array_merge($note->getNotifyAccept(), [$userId])
            );
        }
        $this->em->flush();

        $note = new $noteClass();
        $note->setContent('Užduotis "Perskaityti visus komentarus" įvykdyta');
        $note->setNotify([$userId]);
        $this->em->persist($note);
        $this->em->flush();

        $event = new SocketSendPoolEvent();
        $this->eventDispatcher->dispatch($event, SocketSendPoolEvent::NAME);
    }
}
