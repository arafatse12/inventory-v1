<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Repositories\BrandRepo;

class BrandController extends Controller
{
    private $brandRepo;

    public function __construct(BrandRepo $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    public function index(Request $request)
    {
        $brand = $this->brandRepo->getByPaginate($request);
        return response()->json(returnData(2000, $brand));
    }

    public function create()
    {
    }

    public function store(BrandRequest $request)
    {
        $brand = $this->brandRepo->create($request->all());
        return response()->json(returnData(2000, $brand, 'New brand inserted successfully'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(BrandRequest $request, $primaryKey)
    {
        $brand = $this->brandRepo->find($primaryKey);
        $this->brandRepo->update($brand, $request->all());
        return response()->json(returnData(2000, null, 'Brand updated successfully'));
    }

    public function destroy($primaryKey)
    {
        $this->brandRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Brand deleted successfully'));
    }
}
