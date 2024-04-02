<?php

namespace App\Tests\Project\Task\Domain\Model;

use App\Project\Task\Domain\Model\Props\CreateTaskProps;
use App\Project\Task\Domain\Model\Task;

/**
 * @internal
 */
class TaskMother
{
    public static function default(): Task
    {
        return Task::new(
            CreateTaskProps::from(
                id: '84080b1a-2806-49bf-b413-aebc7c141c29',
                title: 'Task 1',
                description: 'Description 1',
            )
        );
    }
}
