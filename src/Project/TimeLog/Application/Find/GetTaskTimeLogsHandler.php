<?php

namespace App\Project\TimeLog\Application\Find;

use App\Project\Task\Domain\Model\TaskId;
use App\Project\TimeLog\Domain\Model\TimeLog;

final readonly class GetTaskTimeLogsHandler
{
    public function __construct(
        private TimeLogFinder $timeLogFinder,
    ) {
    }

    /**
     * @return iterable<TimeLog>
     */
    public function __invoke(GetTaskTimeLogs $query): iterable
    {
        return $this->timeLogFinder->findByTaskId(TaskId::from($query->taskId));
    }
}
