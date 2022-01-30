<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        $users = $this->userRepo->getByPaginate($request);
        return response()->json(returnData(2000, $users));
    }

    public function create()
    {
    }

    public function store(UserRequest $request)
    {
        $this->userRepo->create($request->all());
        return response()->json(returnData(2000, null, 'New user inserted successfully'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(UserRequest $request, $primaryKey)
    {
        $user = $this->userRepo->find($primaryKey);
        $this->userRepo->update($user, $request->all());
        return response()->json(returnData(2000, null, 'User updated successfully'));
    }

    public function destroy($primaryKey)
    {
        $this->userRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'User deleted successfully'));
    }
}
