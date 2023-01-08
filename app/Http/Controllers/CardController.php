<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardRequest;
use App\Models\Card;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function __construct()
    {

        // $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        // dd($request->query());
        $queries = array();
        foreach ($request->query() as $key => $value) {
            if ($key != 'page') {
                if ($key == 'title')
                    $queries[] = [$key, 'like', '%' . $value . '%'];
                else
                    $queries[] = [$key, $value];
            }
        }
        $cards = Card::select('cards.*', 'filters.filter_name')
            ->join('filters', 'filter_id', '=', 'filters.id')
            ->where($queries)
            ->orderBy('updated_at', 'desc')
            ->paginate(3);
        return response()->json([
            'status' => 'success',
            'cards' => $cards
        ], 200);
    }

    public function getHomeCard(Request $request)
    {
        $queries = array();
        foreach ($request->query() as $key => $value) {
            if ($key != 'cursor') {
                if ($key == 'title')
                    $queries[] = [$key, 'like', '%' . $value . '%'];
                else
                    $queries[] = [$key, $value];
            }
        }
        // dd($queries);
        $cards = Card::where($queries)
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(6);
        return response()->json([
            'status' => 'success',
            'cards' => $cards
        ], 200);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
        $cardData = $request->all();
        if (empty($cardData['status']))
            $cardData['status'] = 'pending';
        try {
            $card = Card::create($cardData);
            return response()->json([
                'status' => 'success',
                'card' => $card
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 500);
        }
    }


    public function show(Card $card)
    {
        //
        return response()->json([
            'status' => 'success',
            'card' => $card
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        //
        $postData = $request->all();
        $card = Card::where('id', $id)->update($postData);
        return response()->json([
            'status' => 'success',
        ], 200);
    }


    public function destroy($id)
    {
        //
        try {
            $card = Card::find($id);
            $card->delete();
            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 500);
        }
    }
}
