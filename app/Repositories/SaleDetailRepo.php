<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\SaleDetail;
use App\Repositories\SaleRepo;
use App\Repositories\Repository;
use App\Repositories\ProductRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class SaleDetailRepo extends Repository
{
    /**
     * @inheritDoc
     */
    private  $productRepo, $saleRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }


    public function model()
    {
        return SaleDetail::class;
    }

    public function findById($productId)
    {
        return  $this->model()::where('product_id', $productId)->first();
    }

    public function findByAll($saleId)
    {
        return  $this->model()::with('product')->where('sale_id', $saleId)->get();
    }

    public function deleteBySaleId($saleId)
    {
        return  $this->model()::where('sale_id', $saleId)->delete();
    }

    public function bulkInsert($array)
    {
        return  $this->model()::insert($array);
    }

    public function soldQty()
    {
        $officeId = Auth::user()->office_id;
        $soldQty = $this->model()::query()
        ->select('product_id',DB::raw("COALESCE(SUM(quantity),0) as totalQty"))
        ->groupBy('product_id')
        ->get();

        return $soldQty;
    }

    public function allDetailsSale()
    {
        $officeId = Auth::user()->office_id;
        $sales = $this->model()::query()->with('product')->where('office_id','=',$officeId)
        ->whereDate('sales.created_at', Carbon::today())
        ->where('status','!=','Return')
        ->leftjoin('sales','sales.id','=','sale_details.sale_id')
        ->get();
        return $sales;
    }

}
