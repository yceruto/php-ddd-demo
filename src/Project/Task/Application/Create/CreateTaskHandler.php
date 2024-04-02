<?php

namespace App\Project\Task\Application\Create;

use App\Project\Task\Domain\Model\Props\CreateTaskProps;

/**
 * Command handler to create a new task.
 *
 * Properties:
 *  - Stateless
 *  - Translate the command into domain value objects
 *  - It uses application services to execute business logic
 *  - Transactional
 */
final readonly class CreateTaskHandler
{
    public function __construct(
        private TaskCreator $creator,
    ) {
    }

    public function handle(CreateTask $command): void
    {
        $this->creator->create(CreateTaskProps::from(
            $command->id,
            $command->title,
            $command->description,
        ));
    }
}
