<div class="mt-10">
    <h2 class="text-2xl font-bold mb-6 border-b pb-2">Customer Reviews</h2>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <p class="mt-4 px-4 py-2 bg-green-100 text-green-800 rounded-lg shadow-sm">{{ session('success') }}</p>
    @elseif (session()->has('error'))
        <p class="mt-4 px-4 py-2 bg-red-100 text-red-800 rounded-lg shadow-sm">{{ session('error') }}</p>
    @endif

    <!-- Reviews List -->
    <div class="space-y-6 mb-8">
        @forelse($reviews as $review)
            <div class="bg-white border rounded-xl shadow hover:shadow-lg transition p-5 relative">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $review['user_name'] ?? 'Anonymous' }}</p>
                        <p class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($review['review_date'])->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.948a1 1 0 00.95.69h4.157c.969 0 1.371 1.24.588 1.81l-3.367 2.448a1 1 0 00-.364 1.118l1.287 3.948c.3.922-.755 1.688-1.54 1.118l-3.367-2.447a1 1 0 00-1.175 0l-3.367 2.447c-.784.57-1.838-.196-1.539-1.118l1.287-3.948a1 1 0 00-.364-1.118L2.068 9.375c-.783-.57-.38-1.81.588-1.81h4.157a1 1 0 00.95-.69l1.286-3.948z"/>
                        </svg>
                        <span class="text-gray-700 font-medium">{{ $review['review_rating'] }}/5</span>
                    </div>
                </div>

                <p class="text-gray-700 mt-2">{{ $review['review_text'] }}</p>

                @auth
                    @if(auth()->id() == $review['user_id'])
                        <button 
                            wire:click="deleteReview('{{ $review['_id'] }}')" 
                            class="absolute top-3 right-3 text-red-600 hover:text-red-800 text-sm font-medium">
                            Delete
                        </button>
                    @endif
                @endauth
            </div>
        @empty
            <p class="text-gray-500">No reviews yet. Be the first to review!</p>
        @endforelse
    </div>

    <!-- Add Review Form -->
    @auth
        <form wire:submit.prevent="submitReview" class="space-y-4 bg-white border rounded-xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Write a Review</h3>
            
            <textarea 
                wire:model="reviewText" 
                rows="4"
                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-orange-500 focus:outline-none resize-none"
                placeholder="Share your thoughts about this product..."></textarea>

            <div class="flex items-center justify-between">
                <div>
                    <label for="rating" class="block mb-2 font-medium text-gray-700">Rating:</label>
                    <select wire:model="reviewRating" id="rating" class="border rounded-lg p-2 w-40">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <button type="submit" 
                    class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition font-medium shadow">
                    Submit Review
                </button>
            </div>
        </form>
    @else
        <p class="text-gray-500 mt-4">Please <a href="{{ route('login') }}" class="text-orange-600 underline">login</a> to leave a review.</p>
    @endauth
</div>
