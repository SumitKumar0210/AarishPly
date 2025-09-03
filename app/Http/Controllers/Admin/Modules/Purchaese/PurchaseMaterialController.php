<?php

namespace App\Http\Controllers\Admin\modules\Purchaese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseMaterial;
use Illuminate\Validation\Rule;

class PurchaseMaterialController extends Controller
{
    public function getData(Request $request)
    {
        try{
            $materials  = PurchaseMaterial::orderBy('id','desc')->paginate(10);
            return response()->json($materials);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch purchase materials'], 500);
        }
        
    }

    public function store(Request $request)
    {
        try{
            
            $request->validate([
                'purchase_order_id' => 'required|exists:purchase_orders,id',
                'material_id'       => 'required|exists:materials,id',
                'qty'               => 'required|integer|min:1',
                'rate'              => 'nullable|numeric',
                'size'              => 'nullable|string|max:225',
                'actual_qty'        => 'nullable|integer',
                'status'            => 'nullable|in:0,1',
            ]);

            $material = new PurchaseMaterial();
            $material->purchase_order_id = $request->purchase_order_id;
            $material->material_id       = $request->material_id;
            $material->qty               = $request->qty;
            $material->rate              = $request->rate;
            $material->size              = $request->size;
            $material->actual_qty        = $request->actual_qty;
            $material->status            = $request->status ?? 0;
            $material->save();
            return response()->json(['message' => 'Purchase material created successfully',
                'data' => $material]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to store purchase material', $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request, $id)
    {
        try{
            $material =PurchaseMaterial::find($id);

            if(!$material){
                return response()->json(['error' => 'Purchase material not found'], 404);
            }
            return response()->json(['message' => 'Purchase material fetch  successfully',
                'data' => $material]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch purchase material', $e->getMessage()], 500);
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'purchase_order_id' => 'required|exists:purchase_orders,id',
                'material_id'       => 'required|exists:materials,id',
                'qty'               => 'required|integer|min:1',
                'rate'              => 'nullable|numeric',
                'size'              => 'nullable|string|max:225',
                'actual_qty'        => 'nullable|integer',
                'status'            => 'nullable|in:0,1',
            ]);
            
            $material =PurchaseMaterial::find($id);
            
            if(!$material){
                return response()->json(['error' => 'Purchase material not found'], 404);
            }

            $material->purchase_order_id = $request->purchase_order_id;
            $material->material_id       = $request->material_id;
            $material->qty               = $request->qty;
            $material->rate              = $request->rate;
            $material->size              = $request->size;
            $material->actual_qty        = $request->actual_qty;
            $material->status            = $request->status ?? $material->status;
            $material->save();

            return response()->json(['message' => 'Purchase material updated  successfully',
                'data' => $material]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch purchase material', $e->getMessage()], 500);
        }
        
    }

    public function delete(Request $request, $id){
        try{
            $material =PurchaseMaterial::find($id);

            if(!$material){
                return response()->json(['error' => 'Purchase material not found'], 404);
            }

            $material->delete();
            return response()->json(['message' => 'Purchase material deleted  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch purchase material', $e->getMessage()], 500);
        }
        
    }

    public function statusUpdate(Request $request)
    {
        try{
            $id = $request->id;
            $material =PurchaseMaterial::find($id);

            if(!$material){
                return response()->json(['error' => 'Purchase material not found'], 404);
            }
            $material->status= !$material->status;
            $material->save();

            return response()->json(['message' => 'Purchase material status updated  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  purchase material', $e->getMessage()], 500);
        }
        
    }
}
