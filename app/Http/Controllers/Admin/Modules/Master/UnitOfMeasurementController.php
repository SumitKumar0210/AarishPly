<?php

namespace App\Http\Controllers\Admin\Modules\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnitOfMeasurement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UnitOfMeasurementController extends Controller
{
    public function getData(Request $request)
    {
        try{
           
            $units = UnitOfMeasurement::orderBy('id','desc')->paginate(10);
            return response()->json($units);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch unit of measurment'], 500);
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
                    Rule::unique('unit_of_measurements', 'name')->whereNull('deleted_at'),
                ],
            ]);

            $unit = new UnitOfMeasurement();
            $unit->name = $request->name;
            $unit->status = $request->status ?? 0;
            $unit->save();
            return response()->json(['message' => 'Unit of measurment created successfully',
                'data' => $unit]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch unit of measurment', $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request, $id)
    {
        try{
            $unit =UnitOfMeasurement::find($id);

            if(!$unit){
                return response()->json(['error' => 'Unit of measurment not found'], 404);
            }
            return response()->json(['message' => 'Unit of measurment fetch  successfully',
                'data' => $unit]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch unit of measurment', $e->getMessage()], 500);
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
                    Rule::unique('unit_of_measurements', 'name')
                        ->ignore($id) 
                        ->whereNull('deleted_at'), 
                ],
                'status' => 'nullable|in:0,1',
            ]);
            $unit =UnitOfMeasurement::find($id);

            if(!$unit){
                return response()->json(['error' => 'Unit of measurment not found'], 404);
            }
            $unit->name = $request->name;
            $unit->status = $request->status ?? $unit->status;
            $unit->save();

            return response()->json(['message' => 'Unit of measurment updated  successfully',
                'data' => $unit]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch unit of measurment', $e->getMessage()], 500);
        }
        
    }

    public function delete(Request $request, $id){
        try{
            $unit =UnitOfMeasurement::find($id);

            if(!$unit){
                return response()->json(['error' => 'Unit of measurment not found'], 404);
            }

            $unit->delete();
            return response()->json(['message' => 'Unit of measurment deleted  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch unit of measurment', $e->getMessage()], 500);
        }
        
    }
}
