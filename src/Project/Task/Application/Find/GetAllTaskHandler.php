<?php

namespace App\Project\Task\Application\Find;

use App\Project\Task\Domain\Model\Task;

/**
 * Query message to get all tasks.
 */
final readonly class GetAllTaskHandler
{
    public function __construct(
        private TaskFinder $finder,
    ) {
    }

    /**
     * @return iterable<Task>
     */
    public function handle(GetAllTask $query): iterable
    {
        return $this->finder->findAll();
    }
}
