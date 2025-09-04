<?php

namespace App\Http\Controllers\Admin\modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesReturn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SalesReturnController extends Controller
{
    public function getData(Request $request)
    {
        try{
            $handTools = SalesReturn::orderBy('id','desc')->paginate(10);
            return response()->json($handTools);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch Sales return'], 500);
        }
        
    }

    public function store(Request $request)
    {
        try{
            
            $request->validate([
                'po_id'       => 'required|integer|exists:production_orders,id',
                'product_id'  => 'required|integer|exists:products,id',
                'qty'         => 'required|numeric|min:1',
                'reason'      => 'nullable|string|max:500',
            ]);


            $handTool = new SalesReturn();

            $handTool->po_id = $request->po_id;
            $handTool->product_id = $request->product_id;
            $handTool->qty = $request->qty;
            $handTool->reason = $request->reason;
            $handTool->status = $request->status ?? 0;
            if($request->hasFile('doc')) {
                $image = $request->file('doc');
               $randomName = rand(10000000, 99999999);
                $imageName = time().'_'.$randomName . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/SalesReport'), $imageName);
                $handTool->doc = '/uploads/SalesReport/'.$imageName;
            }   
            $handTool->save();
            return response()->json(['message' => 'Sales return created successfully',
                'data' => $handTool]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to store sales return', $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request, $id)
    {
        try{
            $handTool =SalesReturn::find($id);

            if(!$handTool){
                return response()->json(['error' => 'Sales return not found'], 404);
            }
            return response()->json(['message' => 'Sales return fetch  successfully',
                'data' => $handTool]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch sales return', $e->getMessage()], 500);
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'po_id'       => 'required|integer|exists:production_orders,id',
                'product_id'  => 'required|integer|exists:products,id',
                'qty'         => 'required|numeric|min:1',
                'reason'      => 'nullable|string|max:500',
            ]);

            $handTool =SalesReturn::find($id);

            if(!$handTool){
                return response()->json(['error' => 'Sales return not found'], 404);
            }
            $handTool->po_id = $request->po_id;
            $handTool->product_id = $request->product_id;
            $handTool->qty = $request->qty;
            $handTool->reason = $request->reason;
            if($request->hasFile('doc')) {
                $image = $request->file('doc');
               $randomName = rand(10000000, 99999999);
                $imageName = time().'_'.$randomName . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/SalesReport'), $imageName);
                $handTool->doc = '/uploads/SalesReport/'.$imageName;
            }   
            $handTool->status = $request->status ?? $handTool->status;
            $handTool->save();

            return response()->json(['message' => 'Sales return updated  successfully',
                'data' => $handTool]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch sales return', $e->getMessage()], 500);
        }
        
    }

    public function delete(Request $request, $id){
        try{
            $handTool =SalesReturn::find($id);

            if(!$handTool){
                return response()->json(['error' => 'Sales return not found'], 404);
            }

            $handTool->delete();
            return response()->json(['message' => 'Sales return deleted  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch sales return', $e->getMessage()], 500);
        }
        
    }

    public function statusUpdate(Request $request)
    {
        try{
            $id = $request->id;
            $handTool =SalesReturn::find($id);

            if(!$handTool){
                return response()->json(['error' => 'Sales return not found'], 404);
            }
            $handTool->status= !$handTool->status;
            $handTool->save();

            return response()->json(['message' => 'Sales return status updated  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  sales return', $e->getMessage()], 500);
        }
        
    }
}
