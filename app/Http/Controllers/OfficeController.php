<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeRequest;
use App\Repositories\OfficeRepo;
use Illuminate\Http\Request;

class OfficeController extends Controller
{

    private $officeRepo;

    public function __construct(OfficeRepo $officeRepo)
    {
        $this->officeRepo = $officeRepo;
    }

    public function index(Request $request)
    {
        $offices = $this->officeRepo->getByPaginate($request);
        return response()->json(returnData(2000, $offices));
    }


    public function store(OfficeRequest $request)
    {
        $this->officeRepo->create($request->all());
        return response()->json(returnData(2000, null, 'Successfully Office Inserted'));
    }

    public function update(OfficeRequest $request, $primaryKey)
    {
        $office = $this->officeRepo->find($primaryKey);
        $this->officeRepo->update($office, $request->all());
        return response()->json(returnData(2000, $office, 'Successfully Office Update'));
    }


    public function destroy($primaryKey)
    {
        $this->officeRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Successfully Office deleted'));
    }
}
