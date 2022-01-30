<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Sale;
use App\Repositories\StockRepo;
use App\Repositories\Repository;
use App\Repositories\ProductRepo;
use App\Http\Requests\SaleRequest;
use Illuminate\Support\Facades\DB;
use App\Repositories\SaleDetailRepo;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StockDetailRepo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SaleRepo extends Repository
{
    /**
     * @inheritDoc
     */
    private $saleDetailRepo, $stockRepo, $stockDetailRepo , $productRepo;

    public function __construct(SaleDetailRepo $saleDetailRepo, StockRepo $stockRepo, StockDetailRepo $stockDetailRepo , ProductRepo $productRepo)
    {
        $this->saleDetailRepo = $saleDetailRepo;
        $this->stockRepo = $stockRepo;
        $this->stockDetailRepo = $stockDetailRepo;
        $this->productRepo = $productRepo;
    }

    public function model()
    {
        return Sale::class;
    }

    public function findByCustomer($saleId)
    {
        return $this->model()::where('id','=',$saleId)->with('customer')->first();
    }

    public function findBySalesDetails()
    {
        $officeId = Auth::user()->office_id;
        return $this->model()::where('office_id','=',$officeId)->where('status','!=','Return')->with('saleDetails')->pluck('id');
    }


    public function getByPaginate($request) : LengthAwarePaginator
    {
        $officeId = Auth::user()->office_id;
        $pagination = $request->per_page ?? 20;
        $filter = $request->keyword;
        return  $this->query()->with('customer','saleDetails.product')->when($filter,function (Builder $sale) use ($filter) {
                return $sale->where('created_at', 'like', "%$filter%");
                return $sale->orWhere('payment_amount	', 'like', "%$filter%");
            }
        )
        ->where('office_id','=',$officeId)
        ->orderBy(sortBy($request)->column, sortBy($request)->sort)
        ->paginate($pagination);
    }

    public function store(SaleRequest $request)
    {
        $officeId = Auth::user()->office_id;
        $collection=  collect($request->products);
        $totalAmount = $collection->sum('amount');
        $discountPercentage = $collection->sum('max_discount_percentage');
        $discountAmount = $collection->sum('max_discount');
        if($request->payment_mode=='Cash'){
           $paymentAmount =  $request->payment_amount;
           $changeAmount =  $request->change_amount;
           $due =  $request->due;
           $bankName =  Null;
           $checqueNo =  Null;
        }else{
            $paymentAmount =  $totalAmount;
            $changeAmount =  0;
            $bankName =   $request->bank_name;
            $checqueNo =   $request->checque_no;
        }

        $stock = [
            'stock_type' =>'Recipte',
            'is_opening' =>'No',
            'posting_date_time' => now(),
            'stock_date' => now(),
            'stock_transcation' => "Out",
            'office_id' => $officeId,
        ];
        $stocks = $this->stockRepo->create($stock);
        $stockDetails = [];
        foreach($request->products as $product){
            $stockDetails[] = [
                'stock_id' => $stocks->id,
                'product_id'=> $product['id'],
                'quantity' =>  $product['item_quantity'],
                'amount' => $product['amount'],
                'purchase_price' => $product['purchase_amount'],
                'sell_price' => $product['sell_price'],
                'markup' => $product['markup']
            ];
        }
        $this->stockDetailRepo->bulkInsert($stockDetails);
        $sale = [
            'customer_id' => $request->customer_id,
            'stock_id' => $stocks->id,
            'total_amount' => $totalAmount,
            'discount_percent' => $discountPercentage,
            'discount_amount' => $discountAmount,
            'payment_amount' => $paymentAmount,
            'change_amount' => $changeAmount,
            'due' => $due,
            'payment_mode' => $request->payment_mode,
            'bank_name' => $bankName,
            'checque_no' => $checqueNo,
            'status' => 'Paid',
            'office_id' => $officeId,
        ];
        $sales = $this->create($sale);
        $saleId =  $sales->id;
        $salesDetails = [];
        foreach($request->products as $product){
            $salesDetails[] = [
                'sale_id' => $saleId,
                'product_id'=> $product['id'],
                'quantity' =>  $product['item_quantity'],
                'purchase_amount' => $product['purchase_amount'],
                'sell_amount' => $product['sell_price'],
                'total' => $product['amount']
            ];
        }
        $saleDetails = $this->saleDetailRepo->bulkInsert($salesDetails);

        $details = $this->saleDetailRepo->findByAll($saleId);
        $sales = $this->findByCustomer($saleId);
        return array($sales, $details);
    }
    public function requestByUpdate(SaleRequest $request,$sale)
    {

        $this->update($sale, $request->all());
        $saleDetails =  $this->saleDetailRepo->findByAll($sale->id);
        $this->saleDetailRepo->deleteBySaleId($sale->id);
        $this->stockDetailRepo->deleteByStockBy($sale->stock_id);


        $officeId = Auth::user()->office_id;
        $collection=  collect($request->products);
        $totalAmount = $collection->sum('amount');
        $discountPercentage = $collection->sum('max_discount_percentage');
        $discountAmount = $collection->sum('max_discount');
        if($request->payment_mode=='Cash'){
           $paymentAmount =  $request->payment_amount;
           $changeAmount =  $request->change_amount;
           $due =  $request->due;
           $bankName =  Null;
           $checqueNo =  Null;
        }else{
            $paymentAmount =  $totalAmount;
            $changeAmount =  0;
            $bankName =   $request->bank_name;
            $checqueNo =   $request->checque_no;
        }

        $stockDetails = [];

        foreach($request->products as $product){
            $stockDetails[] = [
                'stock_id' => $sale->stock_id,
                'product_id'=> $product['id'],
                'quantity' =>  $product['item_quantity'],
                'amount' => $product['amount'],
                'purchase_price' => $product['purchase_amount'],
                'sell_price' => $product['sell_price'],
                'markup' => $product['markup']
            ];
        }
        $this->stockDetailRepo->bulkInsert($stockDetails);
        $saleId =  $sale->id;
        $salesDetails = [];
        foreach($request->products as $product){
            $salesDetails[] = [
                'sale_id' => $saleId,
                'product_id'=> $product['id'],
                'quantity' =>  $product['item_quantity'],
                'purchase_amount' => $product['purchase_amount'],
                'sell_amount' => $product['sell_price'],
                'total' => $product['amount']
            ];
        }
        $saleDetails = $this->saleDetailRepo->bulkInsert($salesDetails);
        $details = $this->saleDetailRepo->findByAll($saleId);
        $sales = $this->findByCustomer($saleId);
        return array($sales, $details);
    }

    public function findByDetails($saleId)
    {
        $salesWithDetails = $this->saleDetailRepo->findByAll($saleId)->pluck('product_id');
        $stockInOut = $this->productRepo->getAllWithProductByStock()->whereIn('id',$salesWithDetails);
        $sales = $this->model()::where('sales.id','=',$saleId)
        ->join('sale_details','sale_details.sale_id','=','sales.id')
        ->join('products','products.id','=','sale_details.product_id')
        ->select('products.id as id','sales.id as sale_id','item_code','sale_details.quantity as item_quantity','products.sell_price as sell_price','products.markup as markup','products.max_discount as max_discount','products.purchase_price as purchase_price','sale_details.total as amount','total_amount','customer_id',DB::raw("0 as discount_percentage"),'discount_amount','payment_amount','sale_details.purchase_amount as purchase_amount','change_amount','payment_mode','bank_name','status','checque_no',DB::raw("1 as stockIn"),DB::raw("null as stockOut"))
        ->get();

        return $sales;
    }

    public function requestBySalesReturnUpdate(SaleRequest $request,$salesReturn)
    {
        $officeId = Auth::user()->office_id;
        $data = [
            'status' => 'return',
        ];
        $this->update($salesReturn, $data);
        $stock = [
            'stock_type' =>'Recipte',
            'is_opening' =>'No',
            'posting_date_time' => now(),
            'stock_date' => now(),
            'stock_transcation' => "In",
            'office_id' => $officeId,
        ];
        $stocks = $this->stockRepo->create($stock);

        $stockDetails = [];

        foreach($request->products as $product){
            $stockDetails[] = [
                'stock_id' => $stocks->id,
                'product_id'=> $product['id'],
                'quantity' =>  $product['item_quantity'],
                'amount' => $product['amount'],
                'purchase_price' => $product['purchase_amount'],
                'sell_price' => $product['sell_price'],
                'markup' => $product['markup']
            ];
        }
        $this->stockDetailRepo->bulkInsert($stockDetails);

    }

    public function soldQty()
    {
        $officeId = Auth::user()->office_id;
        $soldQty = $this->model()::query()->where('office_id','=',$officeId)
        ->where('status','!=','Return')
        ->join('sale_details','sale_details.sale_id','=','sales.id')
        ->select('product_id',DB::raw("COALESCE(SUM(quantity),0) as quantity"))
        ->groupBy('product_id')
        ->get();

        return $soldQty;
    }

    public function getSaleId($officeId)
    {
        $salesId = $this->model()::query()->where('office_id','=',$officeId)
        ->where('status','!=','Return')
        ->pluck('id');

        return $salesId;
    }

    



}
