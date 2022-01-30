<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\StockDetail;
use Illuminate\Http\Request;
use App\Repositories\ProductRepo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    private $productRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index(Request $request)
    {
        $products = $this->productRepo->getByPaginate($request);
        return response()->json(returnData(2000, $products));
    }

    public function create()
    {
    }

    public function store(ProductRequest $request)
    {
        $this->productRepo->store($request);
        return response()->json(returnData(2000, null, 'New product inserted successfully'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(ProductRequest $request, $primaryKey)
    {
        $product = $this->productRepo->find($primaryKey);
        $this->productRepo->requestByUpdate($request,$product);
        return response()->json(returnData(2000, null, 'Product updated successfully'));
    }

    public function destroy($primaryKey)
    {
        $this->productRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Product deleted successfully'));
    }

    public function getSearchByProduct(Request $request){
        $officeId = Auth::user()->office_id;
        $search = $request->keyword;
        $products = $this->productRepo->getAllSearchProduct($request->all());
        return response()->json(returnData(2000, $products, 'success'));
    }

    public function getProductTransfer(Request $request){
        $products = $this->productRepo->getProductTransfer($request->all());
        return response()->json(returnData(2000, $products, 'success'));
    }

}
