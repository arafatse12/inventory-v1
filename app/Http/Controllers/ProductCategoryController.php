<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Repositories\ProductCategoryRepo;
use App\Http\Requests\ProductCategoryRequest;

class ProductCategoryController extends Controller
{
    private $productCategoryRepo;

    public function __construct(ProductCategoryRepo $productCategoryRepo)
    {
        $this->productCategoryRepo = $productCategoryRepo;
    }

    public function index(Request $request)
    {
        $productCategories = $this->productCategoryRepo->getByPaginate($request);
        return response()->json(returnData(2000, $productCategories));
    }

    public function create()
    {
    }

    public function store(ProductCategoryRequest $request)
    {
        $productCategory = $this->productCategoryRepo->create($request->all());
        return response()->json(returnData(2000, $productCategory, 'Product category inserted successfully'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(ProductCategoryRequest $request, $primaryKey)
    {
        $productCategory = $this->productCategoryRepo->find($primaryKey);
        $this->productCategoryRepo->update($productCategory, $request->all());
        return response()->json(returnData(2000, null, 'Product category updated successfully '));
    }

    public function destroy($primaryKey)
    {
        $this->productCategoryRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Product category deleted successfully'));
    }
}
