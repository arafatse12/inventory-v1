<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepo extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Supplier::class;
    }

    public function getByPaginate($request) : LengthAwarePaginator
    {
        $pagination = $request->per_page ?? 20;
        $filter = $request->keyword;
        return $this->query()
            ->when($filter,function (Builder $supplier) use ($filter) {
                return  $supplier->where('name', 'like', "%$filter%")
                        ->orWhere('contact_name', 'like', '%' . $filter . '%')
                        ->orWhere('mobile', 'like', '%' . $filter . '%');
                }
            )
            ->orderBy(sortBy($request)->column, sortBy($request)->sort)
            ->paginate($pagination);
    }

}
?>
