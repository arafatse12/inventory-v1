<?php

namespace App\Repositories;

use App\Models\Office;
use PDF;
use GuzzleHttp\Psr7\Request;
use App\Models\StockTransfer;
use App\Repositories\StockRepo;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StockDetailRepo;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\StockTransferRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class StockTransferRepo extends Repository
{
    /**
     * @inheritDoc
     */
    private $stockRepo, $stockDetailRepo;

    public function __construct(StockRepo $stockRepo, StockDetailRepo $stockDetailRepo)
    {
        $this->stockRepo = $stockRepo;
        $this->stockDetailRepo = $stockDetailRepo;
    }

    public function model()
    {
        return StockTransfer::class;
    }

    public function findById($stockId)
    {
        return  $this->model()::where('stock_id', $stockId)->first();
    }

    public function getByPaginate($request) : LengthAwarePaginator
    {
        $pagination = $request->per_page ?? 20;
        $filter = $request->keyword;
        return  $this->query()->with('office','officeTo','stock','stockDetails')->when($filter,function (Builder $product) use ($filter) {
                return $product->where('purchase_no', 'like', "%$filter%");
            }
        )
        ->orderBy(sortBy($request)->column, sortBy($request)->sort)
        ->paginate($pagination);
    }

    public function store(StockTransferRequest $request)
    {

        $stock = $this->stockRepo->create([
            'stock_type' => 'Transfer',
            'posting_date_time' => $request->posting_date_time,
            'stock_date' => $request->stock_date,
            'stock_transcation' => 'Out',
            'office_id' => auth()->user()->office_id,
        ]);
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
        $stockTransfer = [
            'stock_id' => $stock->id,
            'office_id_from' => $request->office_id_from,
            'office_id_to' => $request->office_id_to,
            'status' => 'Transit'
        ];
        $stock = $this->create($stockTransfer);

    }
    public function requestByUpdate(StockTransferRequest $request, $stockTransfer)
    {
        $this->stockDetailRepo->deleteByStockBy($stockTransfer->stock_id);
        $stock = [
            'posting_date_time' => $request->posting_date_time,
            'stock_date' => $request->stock_date,
        ];
        $stockId = $this->stockRepo->find($request->stock_id);
        $stocks = $this->stockRepo->update($stockId, $stock);
        $stockDetails = [];
        foreach($request->products as $product){
            $stockDetails[] = [
                'stock_id' => $stockTransfer->stock_id,
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

    public function approve($request)
    {
        $stockDetails = $this->stockDetailRepo->findByAll($request->stock_id);
        $user = Auth::user();
        $stockData = [
            'stock_type' => 'Transfer',
            'posting_date_time' => now(),
            'stock_date' => now(),
            'stock_transcation' => 'In',
            'office_id' => $user->office_id,
        ];
        $stock = $this->stockRepo->create($stockData);
        $stockDetail = [];
        foreach($stockDetails as $product){
            $stockDetail[] = [
                'stock_id' => $stock->id,
                'product_id'=> $product['product_id'],
                'quantity' =>  $product['quantity'],
                'amount' => $product['amount'],
                'purchase_price' => $product['purchase_price'],
                'sell_price' => $product['sell_price'],
                'markup' => $product['markup']
            ];
        }
        $this->stockDetailRepo->bulkInsert($stockDetail);
        $statusUpdate = [
            'status' => "Receipt",
        ];
        $stockTransfer = $this->findById($request->stock_id);

        $stockTransfer->update($statusUpdate);

    }

    public function allStockTransfer()
    {
        $officeId = Auth::user()->office_id;
        return  $this->model()::where('office_id_from','=',$officeId)->get();
    }

    public function  transferDetails(){
        $officeId = Auth::user()->office_id;
        return  $this->model()::where('office_id_from','=',$officeId)->where('status','=','Transit')->pluck('stock_id');
    }

    public function createProductTransferPdf() {
        $officeId = Auth::user()->office_id;
        $stockTransfer = $this->transferDetails();

        $products = $this->model()::where('office_id_from', $officeId)
        ->join('stock_details','stock_details.stock_id','=','stock_transfers.stock_id')
        ->select('stock_transfers.*','product_id',DB::raw("COALESCE(SUM(quantity),0) as totalQty"))
        ->groupBy('product_id')
        ->get();

        return  $products ;
      }

}
