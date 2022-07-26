<?php

namespace Newageerp\SfNotes\Object;

use Doctrine\ORM\Mapping as ORM;
use Newageerp\SfBaseEntity\Object\BaseEntity;
use OpenApi\Annotations as OA;

class NoteBase extends BaseEntity
{

    /**
     * @ORM\Column(type="integer")
     */
    protected int $replyTo = 0;

    /**
     * @OA\Property(format="text", type="string")
     * @ORM\Column(type="text")
     */
    protected string $content = '';

    /**
     * @OA\Property(title="parentId")
     * @ORM\Column(type="integer")
     */
    protected int $parentId = 0;

    /**
     * @OA\Property(title="parentSchema")
     * @ORM\Column(type="string")
     */
    protected string $parentSchema = '';

    /**
     * @ORM\Column (type="json")
     * @OA\Property (type="array", @OA\Items(type="number|string"))
     */
    protected ?array $notify = [];

    /**
     * @ORM\Column (type="json")
     * @OA\Property (type="array", @OA\Items(type="number|string"))
     */
    protected ?array $notifyAccept = [];

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string
     */
    public function getParentSchema(): string
    {
        return $this->parentSchema;
    }

    /**
     * @param string $parentSchema
     */
    public function setParentSchema(string $parentSchema): void
    {
        $this->parentSchema = $parentSchema;
    }

    /**
     * @return array|null
     */
    public function getNotify(): ?array
    {
        return $this->notify;
    }

    /**
     * @param array|null $notify
     */
    public function setNotify(?array $notify): void
    {
        $this->notify = $notify;
    }

    /**
     * @return array|null
     */
    public function getNotifyAccept(): ?array
    {
        return $this->notifyAccept;
    }

    /**
     * @param array|null $notifyAccept
     */
    public function setNotifyAccept(?array $notifyAccept): void
    {
        $this->notifyAccept = $notifyAccept;
    }

    /**
     * @return int
     */
    public function getReplyTo(): int
    {
        return $this->replyTo;
    }

    /**
     * @param int $replyTo
     */
    public function setReplyTo(int $replyTo): void
    {
        $this->replyTo = $replyTo;
    }
}