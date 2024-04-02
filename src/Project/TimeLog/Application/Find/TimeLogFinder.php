<?php

namespace App\Project\TimeLog\Application\Find;

use App\Project\Task\Domain\Model\TaskId;
use App\Project\TimeLog\Domain\Error\TimeLogNotFound;
use App\Project\TimeLog\Domain\Model\TimeLog;
use App\Project\TimeLog\Domain\Model\TimeLogId;
use App\Project\TimeLog\Domain\Repository\TimeLogRepository;

/**
 * Service to find time logs.
 */
final readonly class TimeLogFinder
{
    public function __construct(
        private TimeLogRepository $repository
    ) {
    }

    /**
     * @throws TimeLogNotFound
     */
    public function findOne(TimeLogId $id): TimeLog
    {
        return $this->repository->ofId($id) ?? throw TimeLogNotFound::fromId($id);
    }

    /**
     * @return iterable<TimeLog>
     */
    public function findByTaskId(TaskId $taskId): iterable
    {
        return $this->repository->ofTaskId($taskId);
    }
}
