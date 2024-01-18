<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameListItemRequest;
use App\Http\Requests\UpdateGameListItemRequest;
use App\Http\Resources\ListItemResource;
use App\Models\ListItem;

class ListItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ListItemResource::collection(ListItem::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameListItemRequest $request)
    {
        $gl_item = ListItem::create($request->validated());
        //dd($gl_item);
        return ListItemResource::make($gl_item);
    }

    /**
     * Display the specified resource.
     */
    public function show(ListItem $item)
    {
        //($gameListItem);
        return ListItemResource::make($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameListItemRequest $request, ListItem $item)
    {
        $item->update($request->validated());
        return ListItemResource::make($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListItem $item)
    {
        try {
            $item->delete();
            return ListItemResource::make($item);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param $gameId
     * @param $userId
     * @return ListItemResource
     * najde existujuci zaznam pre daneho hraca a danu hru
     */
    public function findListItem($gameId, $userId) {
        $listItem = ListItem::where([
            'game_id' => $gameId,
            'user_id' => $userId,
        ])->first();
        if (!$listItem) {
            return response()->json(['error' => 'Item not found'], 404);
        }
        return ListItemResource::make($listItem);
    }

    public function findListItemsGameId($gameId) {
        $listItem = ListItem::where([
            'game_id' => $gameId,
        ])->get();
        if ($listItem->isEmpty()) {
            return response()->json(['error' => 'Items not found'], 404);
        }
        return ListItemResource::collection($listItem);
    }

    public function findListItemsUserId($userId) {
        $listItem = ListItem::where([
            'user_id' => $userId,
        ])->get();
        if ($listItem->isEmpty()) {
            return response()->json(['error' => 'Items not found'], 404);
        }
        return ListItemResource::collection($listItem);
    }
}
