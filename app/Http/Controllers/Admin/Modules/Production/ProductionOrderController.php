<?php

namespace App\Http\Controllers\Admin\Modules\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductionOrder;
use Illuminate\Validation\Rule;

class ProductionOrderController extends Controller
{
    public function getData(Request $request)
    {
        try{
            $orders = ProductionOrder::orderBy('id','desc')->paginate(10);
            return response()->json($orders);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch Production orders'], 500);
        }
        
    }

    public function store(Request $request)
    {
        try{
            
            $request->validate([
                'quotation_id'       => 'nullable|exists:quotations,id',
                'batch_no'           => 'nullable|string|max:50',
                'product_ids'        => 'nullable',
                'priority'           => 'nullable|string|max:20',
                'customer_id'        => 'nullable|exists:customers,id',
                'commencement_date'  => 'nullable|date',
                'delivery_date'      => 'nullable|date',
                'sale_user_id'       => 'nullable|exists:sales_users,id',
                'unique_code'        => 'nullable|string|max:150|unique:production_orders,unique_code',
                'image'              => 'nullable|string|max:225',
                'revised'            => 'nullable|in:0,1',
                'status'             => 'nullable|in:0,1',
            ]);

            $order = new ProductionOrder();
            $order->quotation_id      = $request->quotation_id;
            $order->batch_no          = $request->batch_no;
            $order->product_ids       = is_array($request->product_ids) ? json_encode($request->product_ids) : $request->product_ids;
            $order->priority          = $request->priority;
            $order->customer_id       = $request->customer_id;
            $order->commencement_date = $request->commencement_date;
            $order->delivery_date     = $request->delivery_date;
            $order->sale_user_id      = $request->sale_user_id;
            $order->unique_code       = $request->unique_code;
            $order->image             = $request->image;
            $order->revised           = $request->revised ?? 0;
            $order->status            = $request->status ?? 0;
            $order->save();

            return response()->json(['message' => 'Production order created successfully',
                'data' => $order]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to store production order', $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request, $id)
    {
        try{
            $order =ProductionOrder::find($id);

            if(!$order){
                return response()->json(['error' => 'Production order not found'], 404);
            }
            return response()->json(['message' => 'Production order fetch  successfully',
                'data' => $order]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch production order', $e->getMessage()], 500);
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'quotation_id'       => 'nullable|exists:quotations,id',
                'batch_no'           => 'nullable|string|max:50',
                'product_ids'        => 'nullable',
                'priority'           => 'nullable|string|max:20',
                'customer_id'        => 'nullable|exists:customers,id',
                'commencement_date'  => 'nullable|date',
                'delivery_date'      => 'nullable|date',
                'sale_user_id'       => 'nullable|exists:sales_users,id',
                'unique_code'        => 'nullable|string|max:150|unique:production_orders,unique_code,' . $id,
                'image'              => 'nullable|string|max:225',
                'revised'            => 'nullable|in:0,1',
                'status'             => 'nullable|in:0,1',
            ]);
            
            $order = ProductionOrder::find($id);
            
            if(!$order){
                return response()->json(['error' => 'Production order not found'], 404);
            }

            $order->quotation_id      = $request->quotation_id;
            $order->batch_no          = $request->batch_no;
            $order->product_ids       = is_array($request->product_ids) ? json_encode($request->product_ids) : $request->product_ids;
            $order->priority          = $request->priority;
            $order->customer_id       = $request->customer_id;
            $order->commencement_date = $request->commencement_date;
            $order->delivery_date     = $request->delivery_date;
            $order->sale_user_id      = $request->sale_user_id;
            $order->unique_code       = $request->unique_code;
            $order->image             = $request->image;
            $order->revised           = $request->revised ?? $order->revised;
            $order->status            = $request->status ?? $order->status;
            $order->save();

            return response()->json(['message' => 'Production order updated  successfully',
                'data' => $order]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch production order', $e->getMessage()], 500);
        }
        
    }

    public function delete(Request $request, $id){
        try{
            $order =ProductionOrder::find($id);

            if(!$order){
                return response()->json(['error' => 'Production order not found'], 404);
            }

            $order->delete();
            return response()->json(['message' => 'Production order deleted  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch production order', $e->getMessage()], 500);
        }
        
    }

    public function statusUpdate(Request $request)
    {
        try{
            $id = $request->id;
            $order =ProductionOrder::find($id);

            if(!$order){
                return response()->json(['error' => 'Production order not found'], 404);
            }
            $order->status= !$order->status;
            $order->save();

            return response()->json(['message' => 'Production order status updated  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  production order', $e->getMessage()], 500);
        }
        
    }
}
