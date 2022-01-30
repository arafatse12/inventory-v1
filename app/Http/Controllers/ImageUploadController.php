<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function index(Request $request)
    {
        $image = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $image);
    	return response()->json(returnData(2000, $image));
    }
}
