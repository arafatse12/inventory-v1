<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Repositories\SupplierRepo;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    private $supplierRepo;

    public function __construct(SupplierRepo $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function index(Request $request)
    {
        $supplier = $this->supplierRepo->getByPaginate($request);
        return response()->json(returnData(2000, $supplier));
    }

    public function create()
    {
    }

    public function store(SupplierRequest $request)
    {
        $this->supplierRepo->create($request->all());
        return response()->json(returnData(2000, null, 'New supplier inserted successfully'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(SupplierRequest $request, $primaryKey)
    {
        $supplier = $this->supplierRepo->find($primaryKey);
        $this->supplierRepo->update($supplier, $request->all());
        return response()->json(returnData(2000,  null, 'Supplier updated successfully'));
    }

    public function destroy($primaryKey)
    {
        $this->supplierRepo->delete($primaryKey);
        return response()->json(returnData(2000,  null, 'Supplier deleted successfully'));
    }
}
