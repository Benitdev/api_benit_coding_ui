<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    //
    public function index()
    {
        //
        $filterList = Filter::get();
        return response()->json([
            'status' => 'success',
            'filterList' => $filterList
        ], 200);
    }
}
