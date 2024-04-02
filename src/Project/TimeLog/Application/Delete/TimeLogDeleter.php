<?php

namespace App\Project\TimeLog\Application\Delete;

use App\Project\Task\Application\Find\TaskFinder;
use App\Project\TimeLog\Application\Find\TimeLogFinder;
use App\Project\TimeLog\Domain\Model\TimeLogId;
use App\Project\TimeLog\Domain\Repository\TimeLogRepository;

/**
 * Service to delete a time log.
 */
final readonly class TimeLogDeleter
{
    public function __construct(
        private TaskFinder $taskFinder,
        private TimeLogFinder $timeLogFinder,
        private TimeLogRepository $repository
    ) {
    }

    public function delete(TimeLogId $id): void
    {
        $timeLog = $this->timeLogFinder->findOne($id);
        $task = $this->taskFinder->findOne($timeLog->taskId());
        $task->undoTimeLog($timeLog);

        $this->repository->remove($timeLog);
    }
}
