<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewHandlerController extends Controller
{
    function showReviewEditScreen($reviewId) {
        $review = Review::find($reviewId);
        $user = User::find($review->user_id);
        if (auth()->user()?->user_id == $user->user_id || auth()->user()?->isAdmin) {
            return view('editReview', ['review' => $review]);
        }
        return redirect('/');
    }
}
