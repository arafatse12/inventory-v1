<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BrandRepo;
use App\Repositories\StockRepo;
use App\Repositories\OfficeRepo;
use App\Repositories\ProductRepo;
use App\Repositories\CustomerRepo;
use App\Repositories\SupplierRepo;
use App\Http\Controllers\Controller;
use App\Repositories\SaleDetailRepo;
use App\Repositories\StockDetailRepo;
use App\Repositories\ProductCategoryRepo;

class HelperController extends Controller
{
    private $productCategoryRepo, $supplierRepo, $brandRepo, $productRepo, $officeRepo, $customerRepo, $stockRepo ,$stockDetailRepo, $saleDetailRepo;

    public function __construct(ProductCategoryRepo $productCategoryRepo, SupplierRepo $supplierRepo, BrandRepo $brandRepo, ProductRepo $productRepo, OfficeRepo $officeRepo, CustomerRepo $customerRepo, StockRepo $stockRepo, StockDetailRepo $stockDetailRepo, SaleDetailRepo $saleDetailRepo)
    {
        $this->productCategoryRepo = $productCategoryRepo;
        $this->supplierRepo = $supplierRepo;
        $this->brandRepo = $brandRepo;
        $this->productRepo = $productRepo;
        $this->officeRepo = $officeRepo;
        $this->customerRepo = $customerRepo;
        $this->stockRepo = $stockRepo;
        $this->stockDetailRepo = $stockDetailRepo;
        $this->saleDetailRepo = $saleDetailRepo;

    }


    public function index()
    {
        $data = [];
        $input = request()->all();

        if (in_array('productCategories', $input)) {
            $data['productCategories'] = $this->productCategoryRepo->getAll();
        }
        if (in_array('suppliers', $input)) {
            $data['suppliers'] = $this->supplierRepo->getAll();
        }
        if (in_array('brands', $input)) {
            $data['brands'] = $this->brandRepo->getAll();
        }
        if (in_array('unitTypes', $input)) {
            $data['unitTypes'] = collect(config('enums.unit_types'));
        }
        if (in_array('products', $input)) {
            $data['products'] = $this->productRepo->getAll();
        }

        if (in_array('offices', $input)) {
            $data['offices'] = $this->officeRepo->getAll();
        }

        if (in_array('customers', $input)) {
            $data['customers'] = $this->customerRepo->getAll();
        }

        if (in_array('allProducts', $input)) {
            $data['allProducts'] = $this->productRepo->getAllWithProduct();
        }

        if (in_array('salesPaymentMode', $input)) {
            $data['salesPaymentMode'] = collect(config('enums.sales_payment_mode'));
        }

        if (in_array('allProductsSearch', $input)) {
            $data['allProductsSearch'] = $this->productRepo->getAllWithProduct();
        }

        if (in_array('purchase_requisition_status', $input)) {
            $data['purchaseRequisitionStatus'] = collect(config('enums.purchase_requisition_status'));
        }

        if (in_array('officesTypes', $input)) {
            $data['officesTypes'] = collect(config('enums.office_types'));
        }

        if (in_array('stockTransfer', $input)) {
            $data['stockTransfer'] = $this->productRepo->getProductTransfer(); 
        }

        if (in_array('allStock', $input)) {
            $data['allStock'] = $this->productRepo->getAllWithProduct();
        }

        if (in_array('detailsSale', $input)) {
            $data['detailsSale'] = $this->saleDetailRepo->allDetailsSale();
        }

        return response()->json(returnData(2000, $data));
    }
}
