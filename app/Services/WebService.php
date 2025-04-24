<?php

namespace App\Services;

use App\Repositories\WebRepository;

class WebService
{
    protected $repository;

    public function __construct(WebRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById($id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        $web = $this->repository->findById($id);
        return $this->repository->update($web, $data);
    }

    public function delete($id)
    {
        $web = $this->repository->findById($id);
        return $this->repository->delete($web);
    }
}
