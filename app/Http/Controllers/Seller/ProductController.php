<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Retrieve the authenticated user
        $user = auth()->user();

        // Mark unseen notifications as seen
        $user->unreadNotifications->each(function ($notification) {
            $notification->update(['read_at' => now()]);
        });

        // Retrieve the products
        $products = Product::orderBy('created_at', 'desc')->get();

        // Load the view with products and the updated unseen notifications count
        return view('pages.seller.products.manage', [
            'products' => $products,
            'unseenNotificationsCount' => 0, // Set the count to 0 after marking them as seen
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.seller.products.add')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Form Validation
        $this->validate($request, [
            'ProductName' => 'required',
            'Category' => 'required',
            'Variation' => 'required',
            'Price' => 'required',
            'Description' => 'required',
            'Quantity' => 'required',
            'ProductImage' => 'required|image|max:2048'
        ], [
            'ProductImage.max' => 'The product image must not exceed 2MB in size.',
        ]);

        $image_folder = str_replace(' ', '-', strtolower($request->input('ProductName')));

        // Handle File Upload
        if ($request->hasFile('ProductImage')) {
            //Get file extension
            $extension = $request->file('ProductImage')->getClientOriginalExtension();
            //File name to store
            $fileNameToStore = $request->input('Variation') . '.' . $extension;
            //Upload the image
            $path = $request->file('ProductImage')->storeAs('public/uploads/images/' . $image_folder, $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Add product to database
        $product = new Product;
        $product->product_name = $request->input('ProductName');
        $product->variation = $request->input('Variation');
        $product->category_id = $request->input('Category');
        $product->description = $request->input('Description');
        $product->availability = $request->input('Quantity');
        $product->price = $request->input('Price');
        $product->image_folder = $image_folder;
        $product->barcode = 0;
        $product->save();

        return redirect(route('products.create'))->with('success', $request->input('ProductName') . ' Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('getCategoryRelation')->where('id', '=', $id)->first();
        return view('pages.seller.products.edit')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Form Validation
        $this->validate($request, [
            'ProductName' => 'required',
            'Category' => 'required',
            'Variation' => 'required',
            'Price' => 'required',
            'Description' => 'required',
            'Quantity' => 'required',
            'ProductImage' => 'image|nullable|max:2048', // Adjust the max size to 2048 KB (2MB)
        ], [
            'ProductImage.max' => 'The product image must not exceed 2MB in size.',
        ]);


        $image_folder = str_replace(' ', '-', strtolower($request->input('ProductName')));

        // Handle File Upload
        if ($request->hasFile('ProductImage')) {
            //Get file extension
            $extension = $request->file('ProductImage')->getClientOriginalExtension();
            //File name to store
            $fileNameToStore = $request->input('Variation') . '.' . $extension;
            //Upload the image
            $path = $request->file('ProductImage')->storeAs('public/uploads/images/' . $image_folder, $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }




        // Get Product
        $product = Product::find($id);

        // Move Image Storage
        $old = 'public/uploads/images/' . $product->image_folder . '/' . $product->variation . '.jpg';
        $new = 'public/uploads/images/' . $image_folder . '/' . $request->input('Variation') . '.jpg';
        if ($old != $new) {
            Storage::move($old, $new);
        }

        // Update Database
        $product->product_name = $request->input('ProductName');
        $product->variation = $request->input('Variation');
        $product->category_id = $request->input('Category');
        $product->description = $request->input('Description');
        $product->availability = $request->input('Quantity');
        $product->price = $request->input('Price');
        $product->image_folder = $image_folder;
        $product->barcode = 0;
        $product->save();

        return redirect(route('products.update', $id))->with('success', $request->input('ProductName') . ' Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        // 
    }

    public function delete(Request $request, Product $product)
    {
        try {
            // Delete the product record from the database
            $product->delete();

            // Delete the product image from storage (if applicable)
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the product'], 500);
        }
    }

    public function suggestion(Request $request)
    {
        // Get the user's input
        $input = $request->input('input');

        // Fetch unique product name suggestions from the database
        $suggestions = Product::where('product_name', 'like', '%' . $input . '%')
            ->distinct() // Add this line to ensure uniqueness
            ->pluck('product_name');

        // Return the suggestions as JSON response
        return response()->json($suggestions);
    }

    public function restock(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');

        $product = Product::find($productId);
        $product->availability += $quantity;
        $product->save();

        // Send back the updated availability value in the response
        return response()->json(['success' => true, 'availability' => $product->availability]);
    }

    public function exportProducts()
    {
        // Fetch all products
        $products = Product::all();

        // Export the data as CSV
        $export = new ProductsExport($products);
        return $export->export();
    }
}
