<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;      
use App\Models\MongoReview;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Get reviews for a product
    public function index($productId)
    {
        $reviews = MongoReview::where('product_id', $productId)
            ->orderBy('review_date', 'desc')
            ->get();

        return response()->json($reviews, 200);
    }

    // Store new review
    public function store(Request $request, $productId)
    {   
        $validated = $request->validate([
            'review_rating' => 'required|integer|min:1|max:5',
            'review_text'   => 'required|string|max:500',
        ]);

        $user = Auth::user();

        $review = Review::create([
            'user_id'       => $user->id, // for mobile API
            'product_id'    => $productId,
            'review_text'   => $validated['review_text'],
            'review_date'   => now(),
            'review_rating' => $validated['review_rating'],
        ]);

        $mongoReview = MongoReview::create([
            'user_id'       => $user->id, // for mobile API
            'product_id'    => $productId,
            'review_text'   => $validated['review_text'],
            'review_date'   => now(),
            'review_rating' => $validated['review_rating'],
            'user_name'     => $user->name,
        ]);

        return response()->json([
            'message' => 'Review submitted successfully!',
            'review'  => $review->load('user'),
            'mongoReview' => $mongoReview,
        ], 201);
    }

    //Get reviews for a product
    public function mobileindex($productId)
    {
        $reviews = Review::with('user')
            ->where('product_id', $productId)
            ->orderBy('review_date', 'desc')
            ->get();

        return response()->json($reviews, 200);
    }

    // Store new review
    public function mobilestore(Request $request, $productId)
    {
        $validated = $request->validate([
            'review_rating' => 'required|integer|min:1|max:5',
            'review_text'   => 'required|string|max:500',
        ]);

        $user = Auth::user();

        $review = Review::create([
            'user_id'       => $user->id, // for mobile API
            'product_id'    => $productId,
            'review_text'   => $validated['review_text'],
            'review_date'   => now(),
            'review_rating' => $validated['review_rating'],
        ]);

        return response()->json([
            'message' => 'Review submitted successfully!',
            'review'  => $review->load('user'),
        ], 201);
    }
}
