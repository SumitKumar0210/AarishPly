<?php

namespace App\Http\Controllers\Admin\Modules\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ViewTypeController extends Controller
{
    public function getData(Request $request)
    {
        try{
            $view_types = ViewType::orderBy('id','desc')->paginate(10);
            return response()->json($view_types);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch view type'], 500);
        }
        
    }

    public function store(Request $request)
    {
        try{
            
            $request->validate([
                'po_id'       => 'required|integer|exists:production_orders,id',
                'view_type'   => 'required|string|max:100',
                'product_id'  => 'required|integer|exists:products,id',
            ]);


            $view_type = new ViewType();

            $view_type->po_id = $request->po_id;
            $view_type->view_type = $request->view_type;
            $view_type->product_id = $request->product_id;
            $view_type->status = $request->status ?? 0;
            $view_type->save();
            return response()->json(['message' => 'View type created successfully',
                'data' => $view_type]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to store view type', $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request, $id)
    {
        try{
            $view_type =ViewType::find($id);

            if(!$view_type){
                return response()->json(['error' => 'View type not found'], 404);
            }
            return response()->json(['message' => 'View type fetch  successfully',
                'data' => $view_type]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch view type', $e->getMessage()], 500);
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'po_id'       => 'required|integer|exists:production_orders,id',
                'view_type'   => 'required|string|max:100',
                'product_id'  => 'required|integer|exists:products,id',
            ]);

            $view_type =ViewType::find($id);

            if(!$view_type){
                return response()->json(['error' => 'View type not found'], 404);
            }
            $view_type->po_id = $request->po_id;
            $view_type->view_type = $request->view_type;
            $view_type->product_id = $request->product_id;
            $view_type->status = $request->status ?? $view_type->status;
            $view_type->save();

            return response()->json(['message' => 'View type updated  successfully',
                'data' => $view_type]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch view type', $e->getMessage()], 500);
        }
        
    }

    public function delete(Request $request, $id){
        try{
            $view_type =ViewType::find($id);

            if(!$view_type){
                return response()->json(['error' => 'View type not found'], 404);
            }

            $view_type->delete();
            return response()->json(['message' => 'View type deleted  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch view type', $e->getMessage()], 500);
        }
        
    }

    public function statusUpdate(Request $request)
    {
        try{
            $id = $request->id;
            $view_type =ViewType::find($id);

            if(!$view_type){
                return response()->json(['error' => 'View type not found'], 404);
            }
            $view_type->status= !$view_type->status;
            $view_type->save();

            return response()->json(['message' => 'View type status updated  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  view type', $e->getMessage()], 500);
        }
        
    }
}
