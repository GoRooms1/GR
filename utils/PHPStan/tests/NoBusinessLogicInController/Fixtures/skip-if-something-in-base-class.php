<?php
declare(strict_types=1);

final class SomeAction
{
    public function __construct(
        protected \Illuminate\Config\Repository $repository
    )
    {
    }

    public function save(): array
    {
        if ($this->repository->has('some')){
            return [];
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->repository->set('some2', 3);
        }
        return ['a'];
    }

}