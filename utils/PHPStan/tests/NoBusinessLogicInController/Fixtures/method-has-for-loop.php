<?php
declare(strict_types=1);

class ErrorsController
{
    public function __construct(
        protected \Illuminate\Cache\Repository $repository
    )
    {
    }

    public function index(): array
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->repository->get('some');
        }
        return [];
    }
}