<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandRepo extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Brand::class;
    }

    public function getByPaginate($request) : LengthAwarePaginator
    {
        $pagination = $request->per_page ?? 20;
        $filter = $request->keyword;
        return $this->query()
            ->when($filter,function (Builder $brand) use ($filter) {
                    return $brand->where('name', 'like', "%$filter%");
            })
            ->orderBy(sortBy($request)->column, sortBy($request)->sort)
            ->paginate($pagination);
    }


}
?>
