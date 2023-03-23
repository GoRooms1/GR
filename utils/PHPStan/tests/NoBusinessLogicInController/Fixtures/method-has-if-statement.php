<?php
declare(strict_types=1);

class ErrorsWithIfController
{
    public function __construct(
        protected \Illuminate\Cache\Repository $repository
    )
    {
    }

    public function index(): array
    {
        if ($this->repository->has('some')) {
            return [true];
        }
        return [];
    }
}