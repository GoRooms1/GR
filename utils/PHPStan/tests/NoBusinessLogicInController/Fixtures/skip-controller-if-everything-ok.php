<?php
declare(strict_types=1);

final class SomeGoogController
{
    public function __construct(
        protected \Illuminate\Config\Repository $repository
    )
    {
    }

    public function index(): \Illuminate\Http\Response
    {
        $result = $this->repository->get('smt');
        return new \Illuminate\Http\Response($result);
    }

}