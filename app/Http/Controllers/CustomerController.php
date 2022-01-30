<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepo;

class CustomerController extends Controller
{
    private $customerRepo;

    public function __construct(CustomerRepo $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function index(Request $request)
    {
        $customers = $this->customerRepo->getByPaginate($request);
        return response()->json(returnData(2000, $customers));
    }


    public function store(CustomerRequest $request)
    {

       $this->customerRepo->create($request->all());

       return response()->json(returnData(2000, null, 'Successfully Customer Inserted'));
    }


    public function update(CustomerRequest $request, $primaryKey)
    {
        $customer = $this->customerRepo->find($primaryKey);
        $this->customerRepo->update($customer, $request->all());
        return response()->json(returnData(2000, $customer, 'Successfully Customer Update'));
    }


    public function destroy($primaryKey)
    {
        $this->customerRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Successfully Customer deleted'));
    }
}
