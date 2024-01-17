<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameListItemRequest;
use App\Http\Requests\UpdateGameListItemRequest;
use App\Http\Resources\GameListItemResource;
use App\Models\GameListItem;

class GameListItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GameListItemResource::collection(GameListItem::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameListItemRequest $request)
    {
        $gl_item = GameListItem::create($request->validated());
        //dd($gl_item);
        return GameListItemResource::make($gl_item);
    }

    /**
     * Display the specified resource.
     */
    public function show(GameListItem $item)
    {
        //($gameListItem);
        return GameListItemResource::make($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameListItemRequest $request, GameListItem $item)
    {
        $item->update($request->validated());
        return GameListItemResource::make($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameListItem $item)
    {
        try {
            $item->delete();
            return GameListItemResource::make($item);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
