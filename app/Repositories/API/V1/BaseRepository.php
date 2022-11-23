<?php

namespace App\Repositories\API\V1;

use App\Interfaces\API\V1\BaseRepositoryI;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryI
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * Initialize a subclass of the model and assign it to the model variable
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create an instance
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Get all instances within the collection
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get an instance by id
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Update an instance by id
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateById(int $id, array $data): bool
    {
        return $this->model
            ->where('id', $id)
            ->update($data);
    }

    /**
     * Delete an instance by id
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->model
            ->where('id', $id)
            ->delete();
    }
}
