<?php

namespace App\Project\TimeLog\Domain\Repository;

use App\Project\Task\Domain\Model\TaskId;
use App\Project\TimeLog\Domain\Model\TimeLog;
use App\Project\TimeLog\Domain\Model\TimeLogId;

interface TimeLogRepository
{
    public function add(TimeLog $timeLog): void;

    public function remove(TimeLog $timeLog): void;

    public function ofId(TimeLogId $id): ?TimeLog;

    /**
     * @return iterable<TimeLog>
     */
    public function ofTaskId(TaskId $taskId): iterable;
}
