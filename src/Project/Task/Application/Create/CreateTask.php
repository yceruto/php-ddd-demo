<?php

namespace App\Project\Task\Application\Create;

/**
 * Command message to create a new task.
 *
 * Properties:
 *  - Immutable
 *  - Primitive types
 *  - It follows the business constraints for optional and required fields.
 */
final readonly class CreateTask
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
    ) {
    }
}
