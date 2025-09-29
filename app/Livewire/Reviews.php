<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MongoReview;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class Reviews extends Component
{
    public $productId;
    public $reviews = [];
    public $reviewText = '';
    public $reviewRating = 5;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->loadReviews();
    }

    // Load reviews directly from MongoDB
    public function loadReviews()
    {
        $this->reviews = MongoReview::where('product_id', $this->productId)
            ->orderBy('review_date', 'desc')
            ->get()
            ->map(function ($review) {
                return [
                    '_id' => (string) $review->_id,
                    'mysql_id' => $review->mysql_id ?? null,
                    'user_id' => $review->user_id,
                    'user_name' => $review->user_name,
                    'review_text' => $review->review_text,
                    'review_rating' => $review->review_rating,
                    'review_date' => $review->review_date,
                ];
            })
            ->toArray();

    }

    // Submit a new review to both MySQL and MongoDB
    public function submitReview()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to submit a review.');
            return;
        }

        $validated = $this->validate([
            'reviewText' => 'required|string|max:500',
            'reviewRating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();

        // Save to MySQL
        $mysqlReview = Review::create([
            'user_id' => $user->id,
            'product_id' => $this->productId,
            'review_text' => $validated['reviewText'],
            'review_rating' => $validated['reviewRating'],
            'review_date' => now(),
        ]);

        // Save to MongoDB
        MongoReview::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'product_id' => $this->productId,
            'review_text' => $validated['reviewText'],
            'review_rating' => $validated['reviewRating'],
            'review_date' => now(),
            'mysql_id' => $mysqlReview->id,
        ]);

        // Clear form and reload reviews from MongoDB
        $this->reviewText = '';
        $this->reviewRating = 5;
        $this->loadReviews();

        session()->flash('success', 'Review submitted successfully!');
    }

    public function deleteReview($mongoId)
    {
        $user = auth()->user();
        if (!$user) {
            session()->flash('error', 'You must be logged in.');
            return;
        }

        $review = MongoReview::find($mongoId);

        if ($review && $review->user_id == $user->id) {
            // Delete from MySQL
            if ($review->mysql_id) {
                Review::where('id', $review->mysql_id)->delete();
            }

            // Delete from MongoDB
            $review->delete();

            $this->loadReviews();
            session()->flash('success', 'Review deleted successfully.');
        } else {
            session()->flash('error', 'Unauthorized or review not found.');
        }
    }



    public function render()
    {
        return view('livewire.reviews');
    }
}
