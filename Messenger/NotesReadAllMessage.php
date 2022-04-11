<?php

namespace Newageerp\SfNotes\Messenger;

use Newageerp\SfMessenger\Object\AsyncMessageLow;

class NotesReadAllMessage extends AsyncMessageLow
{
    protected int $userId = 0;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the value of userId
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @param int $userId
     *
     * @return self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
