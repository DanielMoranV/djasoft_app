<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model::all();
    }
    public function getById($id)
    {
        return $this->model::findOrFail($id);
    }
    public function store(array $data)
    {
        return $this->model::create($data);
    }
    public function update(array $data, $id)
    {
        $record = $this->model::findOrFail($id);
        $record->update($data);
        return $record;
    }
    public function delete($id)
    {
        return $this->model::destroy($id);
    }
}
