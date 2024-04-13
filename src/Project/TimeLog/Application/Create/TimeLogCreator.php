<?php

namespace App\Project\TimeLog\Application\Create;

use App\Project\Task\Application\Find\TaskFinder;
use App\Project\Task\Domain\Model\TaskId;
use App\Project\TimeLog\Domain\Model\Props\CreateTimeLogProps;
use App\Project\TimeLog\Domain\Model\TimeLog;
use App\Project\TimeLog\Domain\Repository\TimeLogRepository;

/**
 * Service to create a time log.
 */
final readonly class TimeLogCreator
{
    public function __construct(
        private TaskFinder $taskFinder,
        private TimeLogRepository $repository,
    ) {
    }

    public function create(CreateTimeLogProps $props, TaskId $taskId): TimeLog
    {
        $task = $this->taskFinder->findOne($taskId);
        $timeLog = $task->newTimeLog($props);

        $this->repository->add($timeLog);

        return $timeLog;
    }
}
