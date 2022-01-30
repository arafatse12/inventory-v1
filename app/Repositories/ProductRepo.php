<?php

namespace App\Repositories;

use App\Models\Office;
use App\Models\Product;
use App\Models\StockDetail;
use GuzzleHttp\Psr7\Request;
use App\Repositories\StockRepo;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Repositories\StockDetailRepo;
use App\Repositories\StockTransferRepo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepo extends Repository
{

    private $stockRepo, $stockDetailRepo, $stockTransferRepo;

    public function __construct(StockRepo $stockRepo, StockDetailRepo $stockDetailRepo, StockTransferRepo $stockTransferRepo)
    {
        $this->stockRepo = $stockRepo;
        $this->stockDetailRepo = $stockDetailRepo;
        $this->stockTransferRepo = $stockTransferRepo;
        
    }

    public function model()
    {
        return Product::class;
    }

    public function getByPaginate($request) : LengthAwarePaginator
    {
        $pagination = $request->per_page ?? 20;
        $filter = $request->keyword;
        return   $this->query()->with('brand:id,name','productCategory:id,name','supplier:id,name','stockDetails.stock')
            ->when($filter,function (Builder $product) use ($filter) {
                    return $product->where('item_code', 'like', "%$filter%")
                    ->orWhere('name', 'like', "%$filter%");
                }
            )
            ->orderBy(sortBy($request)->column, sortBy($request)->sort)
            ->paginate($pagination);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->create($request->all());
        $user = Auth::user();
        if($request->is_opening){
            $amount = $request->sell_price * $request->is_opening;
            $stockData = [
                'stock_type' =>'Recipte',
                'is_opening' =>'Yes',
                'posting_date_time' => now(),
                'stock_date' => now(),
                'stock_transcation' => 'In',
                'office_id' => $user->office_id,
            ];
            $stockData = $this->stockRepo->create($stockData);
            $stockDetailData = [
                'stock_id' =>$stockData->id,
                'product_id'=>$product->id,
                'quantity' => $request->is_opening,
                'amount' => $amount,
                'purchase_price' => $request->purchase_price,
                'sell_price' => $request->sell_price,
                'markup' =>$request->markup
            ];
            $this->stockDetailRepo->create($stockDetailData);
        }
    }

    public function requestByUpdate(ProductRequest $request,$product)
    {
        $this->update($product,$request->all());
        $stockDetail = $this->stockDetailRepo->findById($product->id);
        $stock = $this->stockRepo->find($stockDetail->stock_id);
        if($stockDetail){
            if($stock->is_opening== 'Yes' && $request->is_opening!= $stockDetail->quantity){
                $amount = $request->sell_price * $request->is_opening;
                $this->stockRepo->delete($stockDetail->stock_id);
                $user = Auth::user();
                $stockData = [
                    'stock_type' =>'Recipte',
                    'is_opening' =>'Yes',
                    'posting_date_time' => now(),
                    'stock_date' => now(),
                    'stock_transcation' => 'In',
                    'office_id' => $user->office_id,
                ];
               $stockData = $this->stockRepo->create($stockData);
               $stockDetailData = [
                    'stock_id' =>$stockData->id,
                    'product_id'=>$request->id,
                    'quantity' => $request->is_opening,
                    'amount' => $amount,
                    'purchase_price' => $request->purchase_price,
                    'sell_price' => $request->sell_price,
                    'markup' =>$request->markup
                ];
               $this->stockDetailRepo->create($stockDetailData);
            }
        }

    }

    public function getAllWithStock()
    {
        return $this->model()::with('stockDetails')->get();
    }

    public function findByStock()
    {
        return  $this->model()::where('id',request()->product_id)->with('stockDetails')->first();
    }

    public function getAllWithProduct()
    {
        $officeId = Auth::user()->office_id;
        return $this->query()
        ->withCount(['stockDetail as stockIn' => function ($details) use ($officeId) {
            $details->select(DB::raw("COALESCE(SUM(quantity),0) as totalQty"));
            $details->whereHas('stock', function ($stock) use ($officeId) {
                $stock->where('stock_transcation','=','In');
                $stock->where('office_id','=',$officeId);
            });
        }])
        ->withCount(['stockDetail as stockOut' => function ($details) use ($officeId) {
            $details->select(DB::raw("COALESCE(SUM(quantity),0) as totalQty"));
            $details->whereHas('stock', function ($stock) use ($officeId) {
                $stock->where('stock_transcation','=','Out');
                $stock->where('office_id','=',$officeId);
            });
        }])
        ->having(DB::raw("stockIn-stockOut"),'>',0)
        ->get();
    }

    public function getAllSearchProduct()
    {
        $officeId = Auth::user()->office_id;
        $search = request('keyword');
        $products = $this->query()
        ->where(function ($query) use ($search) {
            if ($search){
                $query->where('item_code', 'like', "%$search%")
                ->orWhere('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%');
            }
        })
        ->withCount(['stockDetail as stockIn' => function ($details) use ($officeId) {
            $details->select(DB::raw("COALESCE(SUM(quantity),0) as totalQty"));
            $details->whereHas('stock', function ($stock) use ($officeId) {
                $stock->where('stock_transcation','=','In');
                $stock->where('office_id','=',$officeId);
            });
        }])
        ->withCount(['stockDetail as stockOut' => function ($details) use ($officeId) {
            $details->select(DB::raw("COALESCE(SUM(quantity),0) as totalQty"));
            $details->whereHas('stock', function ($stock) use ($officeId) {
                $stock->where('stock_transcation','=','Out');
                $stock->where('office_id','=',$officeId);
            });
        }])
        ->having(DB::raw("stockIn-stockOut"),'>',0)
        ->get();
        return $products;
    }

    public function getAllWithProductByStock()
    {
        $officeId = Auth::user()->office_id;
        return $this->query()->select('id')
        ->withCount(['stockDetail as stockIn' => function ($details) use ($officeId) {
            $details->select(DB::raw("COALESCE(SUM(quantity),0) as totalQty"));
            $details->whereHas('stock', function ($stock) use ($officeId) {
                $stock->where('stock_transcation','=','In');
                $stock->where('office_id','=',$officeId);
            });
        }])
        ->withCount(['stockDetail as stockOut' => function ($details) use ($officeId) {
            $details->select(DB::raw("COALESCE(SUM(quantity),0) as totalQty"));
            $details->whereHas('stock', function ($stock) use ($officeId) {
                $stock->where('stock_transcation','=','Out');
                $stock->where('office_id','=',$officeId);
            });
        }])
        ->having(DB::raw("stockIn-stockOut"),'>',0)
        ->get();
    }

    public function getProductTransfer(){
        $officeId = Auth::user()->office_id;
        $stockTransfer = $this->stockTransferRepo->transferDetails();
        $products = StockDetail::join('products','products.id','=','stock_details.product_id')->whereIn('stock_id', $stockTransfer)
        ->select('products.*','product_id',DB::raw("COALESCE(SUM(quantity),0) as totalQty"))
        ->groupBy('product_id')
        ->get();
        return $products;
    }


}
