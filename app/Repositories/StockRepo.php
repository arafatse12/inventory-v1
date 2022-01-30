<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Models\Product;
use App\Models\StockDetail;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StockRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StockDetailRepo;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class StockRepo extends Repository
{

    private $stockDetailRepo;

    public function __construct(StockDetailRepo $stockDetailRepo)
    {
        $this->stockDetailRepo = $stockDetailRepo;
    }

    public function model()
    {
        return Stock::class;
    }

    public function getByPaginate($request) : LengthAwarePaginator
    {
        $pagination = $request->per_page ?? 20;
        $filter = $request->keyword;
        return  $this->query()->with('stockDetails')
            ->when($filter,function (Builder $product) use ($filter) {
                    return $product->where('item_code', 'like', "%$filter%");
                }
            )
            ->orderBy(sortBy($request)->column, sortBy($request)->sort)
            ->paginate($pagination);
    }

    public function store(array $request)
    {
        $stock =  $this->create([
            'stock_type' => 'Recipte',
            'posting_date_time' => $request['posting_date_time'],
            'stock_date' => $request['stock_date'],
            'purchase_order_id' => $request['purchase_order_id'] ?? null,
            'stock_transcation' => 'In',
            'office_id' => auth()->user()->id
        ]);
        foreach($request['products'] as $productItem) {

            $products = [
                'purchase_price' => $productItem['purchase_price'],
                'markup' => $productItem['markup'],
                'sell_price' => $productItem['sell_price'],
            ];

            Product::where('id', $productItem['product_id'])->update($products);
        }

        $this->storeStockDetails($request, $stock->id);
    }

    public function storeStockDetails(array $stockDetails, int $stockID)
    {
        $products = [];

        foreach($stockDetails['products'] as $product){

            $products[] = [
                'stock_id' => $stockID,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'purchase_price' => $product['purchase_price'],
                'amount' => $product['amount'],
                'markup' => $product['markup'] ?? null,
                'sell_price' => $product['sell_price'] ?? $product['purchase_price'],
            ];

        }

        $this->stockDetailRepo->bulkInsert($products);
    }

    public function requestByUpdate(StockRequest $request,$stock)
    {
        $this->stockDetailRepo->deleteByStockBy($stock->id);
        $this->update($stock, $request->all());
        $stockDetails = [];
        foreach($request->products as $product){
            $stockDetails[] = [
                'stock_id' => $stock->id,
                'product_id'=> $product['product_id'],
                'quantity' =>  $product['quantity'],
                'amount' => $product['amount'],
                'purchase_price' => $product['purchase_price'],
                'sell_price' => $product['sell_price'],
                'markup' => $product['markup']
            ];
        }
        $this->stockDetailRepo->bulkInsert($stockDetails);
    }

    public function getProductTransfer(){
        $officeId = Auth::user()->office_id;
        $stockTransfer = $this->stockTransferRepo->transferDetails();
        $products = StockDetail::whereIn('stock_id', $stockTransfer)
        ->select('product_id',DB::raw("COALESCE(SUM(quantity),0) as totalQty"))
        ->groupBy('product_id')
        ->get();
        return response()->json($products);
    }


    public function getAllWithProduct()
    {


        $officeId = Auth::user()->office_id;
        // return $this->model()::join('stock_details','stock_details.stock_id','=','stocks.id')->select('product_id', DB::raw('SUM(CASE WHEN stock_transcation = \'In\' THEN quantity ELSE 0 END) - SUM(CASE WHEN stock_transcation = \'Out\' THEN quantity ELSE 0 END) as quantity'))->groupBy('product_id')->where(['stock_transcation' => 'In','office_id' => $officeId])->Orwhere(['stock_transcation'=>'Out', 'office_id' => $officeId])->orderBy('product_id','DESC')->get();



        // return $this->query()->with('stockDetails')->get();
    }


}
