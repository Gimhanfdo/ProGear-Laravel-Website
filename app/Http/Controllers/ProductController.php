<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //CRUD functions for Admin//

    //Create Product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'productimage' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discountpercentage' => 'nullable|numeric|min:0|max:100',
            'quantityavailable' => 'required|numeric|min:0',
        ]);

        $validated['discountpercentage'] = $validated['discountpercentage'] ?? 0;

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    //Edit product
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'productimage' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discountpercentage' => 'nullable|numeric|min:0|max:100',
            'quantityavailable' => 'required|numeric|min:0',
        ]);

        $validated['discountpercentage'] = $validated['discountpercentage'] ?? 0;

        $product = $this->getProductById($id);
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Delete product
    public function destroy($id)
    {
        $product = $this->getProductById($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    // Get all products
    public function getAllProducts()
    {
        return Product::all();
    }

    // Get products by category
    public function getProductsByCategory($category)
    {
        return Product::where('category', strtolower($category))->get();
    }

    // Get single product by ID
    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    // Get discounted products
    public function getDiscountedProducts()
    {
        return Product::where('discountpercentage', '>', 0)->get();
    }


    //Views//

    // Display all products
    public function index()
    {
        $products = $this->getAllProducts();
        return view('admin.products.index', compact('products'));
    }

    // Display products by category
    public function category($category)
    {
        // Map URL to DB values
        $categories = [
            'bats' => 'Bat',
            'balls' => 'Ball',
            'helmets' => 'Helmet',
            'other' => 'Other',
        ];

        if (!isset($categories[$category])) {
            abort(404);
        }

        $categoryName = $categories[$category];

        return view('products.index', ['category' => $categoryName]);
    }

    // Display single product
    public function show($id)
    {
        $product = $this->getProductById($id);
        
        $relatedProducts = Product::where('category', $product->category)
        ->where('id', '!=', $product->id)
        ->take(4) // limit to 4
        ->get();

    return view('products.show', compact('product', 'relatedProducts'));
    }

    // Display discounted products
    public function discounted()
    {
        return view('products.discounted');
    }

    //Create product page
    public function create()
    {
        return view('admin.products.create');
    }

    // Show edit product page
    public function edit($id)
    {
        $product = $this->getProductById($id);
        return view('admin.products.edit', compact('product'));
    }
}

