<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use LaraPress\Contracts\Posts\Repository as PostRepositoryContract;

abstract class Repository implements PostRepositoryContract
{

    /** @var Model */
    protected $model;

    public function __construct()
    {
        $modelClassName = $this->getModelClassName();

        return $this->model = new $modelClassName;
    }

    /**
     * @param $id
     *
     * @return Model|null
     */
    public function findById($id)
    {
        return $this->newQuery()->where('ID', $id)->get()->first();
    }

    /**
     * @param $name
     *
     * @return Model|null
     */
    public function findByName($name)
    {
        return $this->newQuery()->where('post_name', $name)->get()->first();
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newQuery()
    {
        return $this->model->newQuery();
    }
}
