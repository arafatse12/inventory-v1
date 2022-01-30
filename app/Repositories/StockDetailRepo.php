<?php

namespace App\Repositories;

use App\Models\StockDetail;
use App\Repositories\ProductRepo;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class StockDetailRepo extends Repository {


    public function model()
    {
        return StockDetail::class;
    }

    public function findById($productId)
    {
        return  $this->model()::where('product_id', $productId)->first();

    }

    public function findByAll($stockId)
    {
        return  $this->model()::where('stock_id', $stockId)->get();
    }

    public function deleteByStockBy($stockId)
    {
        return  $this->model()::where('stock_id', $stockId)->delete();
    }

    public function bulkInsert(array $stockDetailsArray)
    {
        return  $this->model()::insert($stockDetailsArray);
    }

}
