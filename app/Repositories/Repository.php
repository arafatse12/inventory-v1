<?php
namespace App\Repositories;


abstract class Repository
{
    /**
     * Define relevant Model.
     *
     * @return Model | Builder;
     */
    abstract public function model();

    /**
     * Define relevant Model.
     *
     * @return Builder;
     */
    public function query()
    {
        return $this->model()::query();
    }

    /**
     * @return Collection;
     */
    public function getAll()
    {
        return $this->model()::all();
    }

    /**
     * @return first limit 1 Collection;
     */
    public function first()
    {
        return $this->model()::first();
    }

    /**
     * @param $primaryKey
     * @return Collection;
     */
    public function find($primaryKey)
    {
        return $this->model()::find($primaryKey);
    }

    /**
     * @param $primaryKey
     * @return bool;
     */
    public function delete($primaryKey)
    {
        return $this->model()::destroy($primaryKey);
    }

    /**
     * @param $data
     * @return bool;
     */
    public function create(array $data)
    {
        return $this->model()::create($data);
    }

    /**
     * @param $model , $data
     * @return bool;
     */
    public function update($model, array $data)
    {
        return $model->update($data);
    }

}

?>
