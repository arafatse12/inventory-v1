<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Repositories\PurchaseOrderDetailsRepo;
use App\Repositories\StockDetailRepo;
use App\Repositories\Repository;
use Illuminate\Database\Query\Builder;


class PurchaseOrderRepo extends Repository {

    private $purchaseDetailsRepo, $stockDetailRepo, $stockRepo;

    public function __construct(
        PurchaseOrderDetailsRepo $purchaseDetailsRepo,
        StockDetailRepo $stockDetailRepo,
        StockRepo $stockRepo
    )
    {
        $this->purchaseDetailsRepo = $purchaseDetailsRepo;
        $this->stockDetailRepo = $stockDetailRepo;
        $this->stockRepo = $stockRepo;
    }

    public function model()
    {
        return PurchaseOrder::class;
    }

    public function getByPaginate($request) : Array
    {

        $pagination = $request->per_page ?? config('enums.per_page');
        $filter = $request->keyword;

        $suppliers = Supplier::query()->select('id', 'name')->get();
        $products = Product::query()->select('id', 'item_code', 'sell_price')->get();
        $purchaseOrders =  $this->query()->with('supplier', 'purchaseOrderDetails')->when($filter,function (Builder $purchaseOrder) use ($filter) {
                    return $purchaseOrder->where('id', 'like', "%$filter%");
                })
            ->orderBy(sortBy($request)->column, sortBy($request)->sort)
            ->paginate($pagination);

        $data = [
            'products' => $products,
            'suppliers' => $suppliers,
            'purchaseOrders' => $purchaseOrders
        ];

        return $data;
    }

    public function store(array $request)
    {
        $amountCollection = collect($request['products']);

        $purchaseOrder = $this->create([
            'supplier_id' => $request['supplier_id'],
            'status' => 'paid',
            'tax' => $request['tax'],
            'date' => $request['date'],
            'total_amount' => $amountCollection->sum('amount'),
            'office_id' => auth()->user()->office_id,
        ]);

        foreach($request['products'] as $product){
            $this->purchaseDetailsRepo->store($product, $purchaseOrder);
        }
    }

    public function storeStock(array $request)
    {
        $stock =  $this->stockRepo->create([
            'stock_type' => 'Recipte',
            'posting_date_time' => $request['posting_date_time'],
            'stock_date' => $request['stock_date'],
            'purchase_order_id' => $request['purchase_order_id'] ?? null,
            'stock_transcation' => 'In',
            'office_id' => auth()->user()->id
        ]);
        $products = [];

        foreach($request['products'] as $productItem){

            $products = [
                'stock_id' => $stock->id,
                'product_id' => $productItem['product_id'],
                'quantity' => $productItem['quantity'],
                'purchase_price' => $productItem['purchase_price'],
                'amount' => $productItem['amount'],
                'markup' => $productItem['markup'] ?? null,
                'sell_price' => $productItem['sell_price'] ?? $productItem['purchase_price'],
            ];

        }

        $this->stockDetailRepo->bulkInsert($products);
    }
}
?>
