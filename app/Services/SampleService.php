<?php

namespace App\Services;

use App\Models\Sample;
use App\Repositories\SampleRepository;
use App\Repositories\SampleRepositoryEloquent;

class SampleService extends Service
{
    protected SampleRepository $repository;

    public function __construct()
    {
        $this->repository = new SampleRepositoryEloquent(app());
    }

    public function samples(array $params): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        /** @var Sample $query */
        $query = $this->repository;
        $page = $params['page'];
        $perPage = $params['perPage'];
        return $query->query()
            ->select([
                'id',
                'code',
                'name',
                'value',
               ])
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], "samples - $page", $page);
    }

    public function values(): array
    {
        /** @var Sample $query */
        $query = $this->repository;

        return $query->query()
            ->select([
                'id as value',
                'name as title',
               ])
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }

    public function create(array $attributes): bool
    {
        return $this->repository->create($attributes)->exists();
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->repository->update($attributes, $id)->wasChanged();
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
