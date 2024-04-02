<?php

namespace App\Project\TimeLog\Application\Find;

use App\Project\TimeLog\Domain\Model\TimeLog;
use App\Project\TimeLog\Domain\Model\TimeLogId;

/**
 * Query handler to find a time log.
 */
final readonly class FindTimeLogHandler
{
    public function __construct(
        private TimeLogFinder $finder,
    ) {
    }

    public function handle(FindTimeLog $query): TimeLog
    {
        return $this->finder->findOne(TimeLogId::from($query->id));
    }
}
