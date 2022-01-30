<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCategoryRepo extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return ProductCategory::class;
    }

    public function getByPaginate($request) : LengthAwarePaginator
    {
        $pagination = $request->per_page ?? config('enums.per_page');
        $filter = $request->keyword;
        return $this->query()
            ->when($filter,function (Builder $productCategory) use ($filter) {
                    return $productCategory->where('name', 'like', "%$filter%");
                }
            )
            ->orderBy(sortBy($request)->column, sortBy($request)->sort)
            ->paginate($pagination);
    }


}
?>
