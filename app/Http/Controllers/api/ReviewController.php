<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReviewResource::collection(Review::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $review = Review::create($request->validated());
        return ReviewResource::make($review);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return ReviewResource::make($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());
        return ReviewResource::make($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return ReviewResource::make($review);
    }

    public function reviewsForGame($gameId) {
        $reviews = Review::where('game_id', $gameId)->get();
        return ReviewResource::collection($reviews);
    }

    /**
     * @param $gameId
     * @param $userId
     * @return
     * najde existujuci zaznam pre daneho hraca a danu hru
     */
    public function findReview($gameId, $userId) {
        $review = Review::checkReviewExistance($gameId, $userId);
        return response()->json(['exists' => $review]);
    }
}
