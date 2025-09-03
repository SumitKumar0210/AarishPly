<?php

namespace App\Http\Controllers\Admin\modules\Quotation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quotation;
use Illuminate\Validation\Rule;

class QuotationOrderController extends Controller
{
    public function getData(Request $request)
    {
        try{
            $orders = Quotation::orderBy('id','desc')->paginate(10);
            return response()->json($orders);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch Quotation orders'], 500);
        }
        
    }

    public function store(Request $request)
    {
        try{
            
            $request->validate([
                'batch_no'           => 'nullable|string|max:50',
                'product_ids'        => 'nullable',
                'priority'           => 'nullable|string|max:20',
                'customer_id'        => 'nullable|exists:customers,id',
                'commencement_date'  => 'nullable|date',
                'delivery_date'      => 'nullable|date',
                'sale_user_id'       => 'nullable|exists:sales_users,id',
                'unique_code'        => 'nullable|string|max:150|unique:quotations,unique_code',
                'image'              => 'nullable|string|max:225',
                'revised'            => 'nullable|in:0,1',
                'status'             => 'nullable|in:0,1',
            ]);

            $order = new Quotation();
            $order->batch_no          = $request->batch_no;
            $order->product_ids       = is_array($request->product_ids) ? json_encode($request->product_ids) : $request->product_ids;
            $order->priority          = $request->priority;
            $order->customer_id       = $request->customer_id;
            $order->commencement_date = $request->commencement_date;
            $order->delivery_date     = $request->delivery_date;
            $order->sale_user_id      = $request->sale_user_id;
            $order->unique_code       = $request->unique_code;
            if($request->has('image')){
                $image = $request->file('image');
                $randomName = rand(10000000, 99999999);
                $imageName = time().'_'.$randomName . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/materials/'), $imageName);
                $order->image = '/uploads/quotation/'.$imageName;

            }
            $order->revised           = $request->revised ?? 0;
            $order->status            = $request->status ?? 0;
            $order->save();

            return response()->json(['message' => 'Quotation order created successfully',
                'data' => $order]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to store quotation order', $e->getMessage()], 500);
        }
        
    }

    public function edit(Request $request, $id)
    {
        try{
            $order =Quotation::find($id);

            if(!$order){
                return response()->json(['error' => 'Quotation order not found'], 404);
            }
            return response()->json(['message' => 'Quotation order fetch  successfully',
                'data' => $order]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch quotation order', $e->getMessage()], 500);
        }
        
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'batch_no'           => 'nullable|string|max:50',
                'product_ids'        => 'nullable',
                'priority'           => 'nullable|string|max:20',
                'customer_id'        => 'nullable|exists:customers,id',
                'commencement_date'  => 'nullable|date',
                'delivery_date'      => 'nullable|date',
                'sale_user_id'       => 'nullable|exists:sales_users,id',
                'unique_code'        => 'nullable|string|max:150|unique:quotations,unique_code,' . $id,
                'image'              => 'nullable|string|max:225',
                'revised'            => 'nullable|in:0,1',
                'status'             => 'nullable|in:0,1',
            ]);
            
            $order = Quotation::find($id);
            
            if(!$order){
                return response()->json(['error' => 'Quotation order not found'], 404);
            }

            $order->batch_no          = $request->batch_no;
            $order->product_ids       = is_array($request->product_ids) ? json_encode($request->product_ids) : $request->product_ids;
            $order->priority          = $request->priority;
            $order->customer_id       = $request->customer_id;
            $order->commencement_date = $request->commencement_date;
            $order->delivery_date     = $request->delivery_date;
            $order->sale_user_id      = $request->sale_user_id;
            $order->unique_code       = $request->unique_code;
            if($request->has('image')){
                $image = $request->file('image');
                $randomName = rand(10000000, 99999999);
                $imageName = time().'_'.$randomName . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/materials/'), $imageName);
                $order->image = '/uploads/quotation/'.$imageName;

            }
            $order->revised           = $request->revised ?? $order->revised;
            $order->status            = $request->status ?? $order->status;
            $order->save();

            return response()->json(['message' => 'Quotation order updated  successfully',
                'data' => $order]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch quotation order', $e->getMessage()], 500);
        }
        
    }

    public function delete(Request $request, $id){
        try{
            $order =Quotation::find($id);

            if(!$order){
                return response()->json(['error' => 'Quotation order not found'], 404);
            }

            $order->delete();
            return response()->json(['message' => 'Quotation order deleted  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch quotation order', $e->getMessage()], 500);
        }
        
    }

    public function statusUpdate(Request $request)
    {
        try{
            $id = $request->id;
            $order =Quotation::find($id);

            if(!$order){
                return response()->json(['error' => 'Quotation order not found'], 404);
            }
            $order->status= !$order->status;
            $order->save();

            return response()->json(['message' => 'Quotation order status updated  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  Quotation order', $e->getMessage()], 500);
        }
        
    }
}
