<?php

namespace App\Project\Task\Domain\Model;

enum TaskStatus: string
{
    case PROPOSAL = 'proposal';
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public function isProposal(): bool
    {
        return self::PROPOSAL === $this;
    }

    public function isTodo(): bool
    {
        return self::TODO === $this;
    }

    public function isInProgress(): bool
    {
        return self::IN_PROGRESS === $this;
    }

    public function isDone(): bool
    {
        return self::DONE === $this;
    }

    public function equals(self $status): bool
    {
        return $this === $status;
    }

    public function canApply(self $status): bool
    {
        if ($status->equals($this)) {
            return true;
        }

        return match ($this) {
            self::PROPOSAL => $status->isTodo(),
            self::TODO => $status->isInProgress() || $status->isProposal(),
            self::IN_PROGRESS => $status->isDone() || $status->isTodo() || $status->isProposal(),
            default => false,
        };
    }

    public function toString(): string
    {
        return $this->value;
    }
}
