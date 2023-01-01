<?php


namespace App\Services;


use App\Models\Card;
use Exception;
use Illuminate\Support\Facades\Log;

class CardService
{
    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    function getList()
    {
        $cards = $this->card->get();

        return $cards;
    }

    function insertcard($request)
    {
        try {
            $this->card::create($request);

            return true;
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }
    }

    function updatecard($request, $id)
    {
        try {
            $this->card = Card::find($id);
            $this->card->title = $request->title;
            $this->card->description = $request->description;
            $this->card->save();
            return true;
        } catch (Exception $e) {
            Log::error($e);

            return false;
        }
    }
}
