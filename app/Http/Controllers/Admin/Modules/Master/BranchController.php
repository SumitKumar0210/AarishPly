<?php

namespace App\Http\Controllers\Admin\Modules\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function getData(Request $request)
    {
        try{
            $branches = Branch::orderBy('id','desc')->paginate(10);
            return response()->json($branches);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch branch'], 500);
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
                    Rule::unique('branches', 'name')->whereNull('deleted_at'),
                ],
            ]);

            $branch = new Branch();

            $branch->name = $request->name;
            $branch->mobile = $request->mobile;
            $branch->address = $request->address;
            $branch->status = $request->status ?? 0;
            $branch->save();
            return response()->json(['message' => 'Branch created successfully',
                'data' => $branch]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to store branch', $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request, $id)
    {
        try{
            $branch =Branch::find($id);

            if(!$branch){
                return response()->json(['error' => 'Branch not found'], 404);
            }
            return response()->json(['message' => 'Branch fetch  successfully',
                'data' => $branch]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch branch', $e->getMessage()], 500);
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('branches', 'name')
                        ->ignore($id) 
                        ->whereNull('deleted_at'), 
                ],
                'status' => 'nullable|in:0,1',
            ]);
            $branch =Branch::find($id);

            if(!$branch){
                return response()->json(['error' => 'Branch not found'], 404);
            }
            $branch->name = $request->name;
            $branch->mobile = $request->mobile;
            $branch->address = $request->address;
            $branch->status = $request->status ?? $branch->status;
            $branch->save();

            return response()->json(['message' => 'Branch updated  successfully',
                'data' => $branch]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch branch', $e->getMessage()], 500);
        }
        
    }

    public function delete(Request $request, $id){
        try{
            $branch =Branch::find($id);

            if(!$branch){
                return response()->json(['error' => 'Branch not found'], 404);
            }

            $branch->delete();
            return response()->json(['message' => 'Branch deleted  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch branch', $e->getMessage()], 500);
        }
        
    }

    public function statusUpdate(Request $request)
    {
        try{
            $id = $request->id;
            $branch =Branch::find($id);

            if(!$branch){
                return response()->json(['error' => 'Branch not found'], 404);
            }
            $branch->status= !$branch->status;
            $branch->save();

            return response()->json(['message' => 'Branch status updated  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  branch', $e->getMessage()], 500);
        }
        
    }
}
