<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = ['id', 'name', 'description', 'categories', 'price']; // Define searchable columns (remove 'categories' if not needed)
            $query = Product::select($columns);

            // Handle search input from DataTables
            if ($request->has('search') && !empty($request->input('search')['value'])) {
                $searchValue = $request->input('search')['value'];
                $query->where(function($q) use ($searchValue, $columns) {
                    foreach ($columns as $column) {
                        $q->orWhere($column, 'like', '%' . $searchValue . '%');
                    }
                });
            }

            // Return JSON response with pagination
            return datatables()->of($query)
                ->rawColumns(['id', 'name', 'description', 'categories', 'price']) // If you have HTML in any column
                ->make(true);
        }

        return view('products');
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Adjust image validation as needed
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/product_images', $imageName);  // Store image in storage/app/public/product_images directory
        } else {
            return response()->json(['message' => 'Image file is required.'], 422);
        }

        // Create new product
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $imageName;  // Store image filename in database
        $product->save();

        return response()->json(['message' => 'Product added successfully'], 200);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json($product, 200);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        $product->update($validatedData);

        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(null, 204);
    }
}
