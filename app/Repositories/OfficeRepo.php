<?php

namespace App\Repositories;

use App\Models\Office;
use App\Repositories\Repository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class OfficeRepo extends Repository
{

    public function model()
    {
        return Office::class;
    }

    public function getParentsOffice()
    {
      return  $this->model()::whereNull('parent_id')->get();
    }

    public function getByPaginate($request) : Array
    {
        $pagination = $request->per_page ?? config('enums.per_page');
        $filter = $request->keyword;

        $offices = $this->query()->with('offices')->when($filter, function (Builder $office) use ($filter) {
                return $office->where('name', 'like', "%$filter%");
          })
          ->orderBy(sortBy($request)->column, sortBy($request)->sort)
          ->paginate($pagination);

        $allData = [
            'parentsOffices' => $this->getParentsOffice(),
            'offices' => $offices
        ];

        return $allData;
    }

}
?>
