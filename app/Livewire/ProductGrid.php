<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductGrid extends Component
{
    use WithPagination;

    public $category = null;          // set from Blade: :category="$category"
    public $discountedOnly = false;   // set from Blade: :discounted-only="true"
    public $perPage = 12;

    // Keep filter state in the URL (optional)
    protected $queryString = [
        'category' => ['except' => null],
        'discountedOnly' => ['except' => false],
        'page' => ['except' => 1],
    ];

    // Accept initial values when component is mounted
    public function mount($category = null, $discountedOnly = false)
    {
        $this->category = $category;
        // convert string "true" / bool to boolean robustly
        $this->discountedOnly = filter_var($discountedOnly, FILTER_VALIDATE_BOOLEAN);
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query();

        if ($this->category) {
            // store categories in lowercase or normalize
            $query->where('category', $this->category);
        }

        if ($this->discountedOnly) {
            $query->where('discountpercentage', '>', 0);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.product-grid', [
            'products' => $products
        ]);
    }
}
