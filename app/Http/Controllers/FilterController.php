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
    public function store(Request $request)
    {
        //
        $filterData = $request->all();
        if (empty($filterData['status']))
            $filterData['status'] = 'pending';
        try {
            $card = Filter::create($filterData);
            return response()->json([
                'status' => 'success',
                'filter' => $card
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 500);
        }
    }
}
