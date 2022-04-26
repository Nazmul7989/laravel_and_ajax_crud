<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data['products'] = Product::with('sub_category.category')
            ->select('id','title','price','subcategory_id','description','thumbnail')
            ->get();

        $data['subcategories'] = Subcategory::select('id','title')->get();

        return view('admin.product.index',$data);
    }

    public function get(Request $request)
    {

        $products = Product::with('sub_category.category')
            ->select('id','title','price','subcategory_id','description','thumbnail')
            ->get();

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }


    public function store(Request $request)
    {

        $product = new Product();

        //Save product image
        if ($request->hasFile('thumbnail')){
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $image = "Product_".time().".".$extension;
            $file->move(public_path('/uploads/products/'),$image);
            $product->thumbnail = '/uploads/products/' .$image;
        }

        $product->title           = $request->title;
        $product->price           = $request->price;
        $product->subcategory_id  = $request->subcategory_id;
        $product->description     = $request->description;
        $product->save();

        return response()->json([
            'status'  => true,
            'data'    => $product,
            'message' => 'Product uploaded successfully.'
        ]);

    }

    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($id);

        //Save product image
        if ($request->hasFile('thumbnail')){
            $image_path = public_path($product->thumbnail);
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $image = "Product_".time().".".$extension;
            $file->move(public_path('/uploads/products/'),$image);
            $product->thumbnail = '/uploads/products/' .$image;
        }

        $product->title           = $request->title;
        $product->price           = $request->price;
        $product->subcategory_id  = $request->subcategory_id;
        $product->description     = $request->description;
        $product->save();

        return response()->json([
            'status'  => true,
            'data'    => $product,
            'message' => 'Product uploaded successfully.'
        ]);

    }

    public function delete($id)
    {

        $product = Product::findOrFail($id);

        $image_path = public_path($product->thumbnail);

        if (file_exists($image_path)) {
            @unlink($image_path);
        }

        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product deleted successfully.'
        ]);



    }
}
