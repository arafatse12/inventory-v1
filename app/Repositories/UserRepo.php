<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Repository;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepo extends Repository
{
    /**
     * @inheritDoc
     */

    public function model()
    {
        return User::class;
    }

    public function getByPaginate($request) : LengthAwarePaginator
    {
        $pagination = $request->per_page ?? config('enums.per_page');
        $filter = $request->keyword;

        $users = $this->query()->with('office:id,name')->when($filter, function (Builder $user) use ($filter) {
                return  $user->where('name', 'like', "%$filter%")
                ->orWhere('username', 'like', '%' . $filter . '%')
                ->orWhere('email', 'like', '%' . $filter . '%');
          })
          ->orderBy(sortBy($request)->column, sortBy($request)->sort)
          ->paginate($pagination);

        return $users;
    }

    public function store(UserRequest $request)
    {
        $user = [
            'name' => $request->name,
            'email' =>$request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'office_id' => $request->office_id,
            'address' => $request->address,
            'phone' => $request->phone,
        ];
        $this->create($user);
    }

}
