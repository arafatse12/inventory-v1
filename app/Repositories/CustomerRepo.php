<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Repository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class CustomerRepo extends Repository
{

    public function model()
    {
        return Customer::class;
    }

    public function getByPaginate($request) : Array
    {

        $pagination = $request->per_page ?? config('enums.per_page');
        $filter = $request->keyword;
        $offices = DB::table('offices')->get();

        $customers = $this->query()->with('office')
            ->when($filter,function (Builder $customer) use ($filter) {
                    return $customer->where('name', 'like', "%$filter%");
                }
            )
            ->orderBy(sortBy($request)->column, sortBy($request)->sort)
            ->paginate($pagination);

        $customeriWithOfficess = ['customers' => $customers, 'offices' => $offices];

        return $customeriWithOfficess;
    }

}
?>
