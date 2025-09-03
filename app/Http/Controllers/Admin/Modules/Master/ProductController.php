<?php

namespace App\Http\Controllers\Admin\modules\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function getData(Request $request)
    {
        try{
            $products = Product::orderBy('id','desc')->paginate(10);
            return response()->json($products);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch Products'], 500);
        }
        
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('products', 'name')->whereNull('deleted_at'),
                ],
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->modal = $request->modal;
            $product->size = $request->size ;
            $product->color = $request->color;
            $product->hsn_code = $request->hsn_code;
            $product->rrp = round($request->rrp,2);
            $product->product_type = $request->product_type;
            $product->group_id = $request->group_id;
            if($request->has('image')){
                $image = $request->file('image');
                $randomName = rand(10000000, 99999999);
                $imageName = time().'_'.$randomName . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products/'), $imageName);
                $product->image = '/uploads/Products/'.$imageName;

            }
           
            $product->status = $request->status ?? 0;
            $product->save();
          
            return response()->json(['message' => 'Product created successfully',
                'data' => $product]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to store product', $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request, $id)
    {
        try{

            $product =Product::find($id);

            if(!$product){
                return response()->json(['error' => 'Product not found'], 404);
            }
            return response()->json(['message' => 'Product fetch  successfully',
                'data' => $product]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch product', $e->getMessage()], 500);
        }
        
    }

    public function update(Request $request, $id){
        try{

            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('products', 'name')->ignore($id)->whereNull('deleted_at'),
                ],
            ]);

            $product =Product::find($id);

            if(!$product){
                return response()->json(['error' => 'Product not found'], 404);
            }

            $product->name = $request->name;
            $product->modal = $request->modal;
            $product->size = $request->size ;
            $product->color = $request->color;
            $product->hsn_code = $request->hsn_code;
            $product->rrp = round($request->rrp,2);
            $product->product_type = $request->product_type;
            $product->group_id = $request->group_id;
            if($request->has('image')){
                $image = $request->file('image');
                $randomName = rand(10000000, 99999999);
                $imageName = time().'_'.$randomName . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products/'), $imageName);
                $product->image = '/uploads/Products/'.$imageName;

            }
            $product->status = $request->status ?? $product->status;
            $product->save();

            return response()->json(['message' => 'Product updated  successfully',
                'data' => $product]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to update product', $e->getMessage()], 500);
        }
        
    }

    public function delete(Request $request, $id)
    {
        try{

            $product =Product::find($id);

            if(!$product){
                return response()->json(['error' => 'Product not found'], 404);
            }
            $product->delete();

            return response()->json(['message' => 'Product deleted  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to delete product', $e->getMessage()], 500);
        }
        
    }

    public function statusUpdate(Request $request)
    {
        try{
            $id = $request->id;
            $product =Product::find($id);

            if(!$product){
                return response()->json(['error' => 'Product not found'], 404);
            }
            $product->status= !$product->status;
            $product->save();

            return response()->json(['message' => 'Product status updated  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  product', $e->getMessage()], 500);
        }
        
    }
}
