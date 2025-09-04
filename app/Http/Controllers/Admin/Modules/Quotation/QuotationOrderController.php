<?php

namespace App\Http\Controllers\Admin\Modules\Quotation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\ProductionOrder;
use App\Models\ProductionProduct;
use App\Models\ViewType;
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
// dd($request->all());
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
                $image->move(public_path('uploads/quotation/'), $imageName);
                $order->image = '/uploads/quotation/'.$imageName;

            }
            $order->revised           = $request->revised ?? 0;
            $order->status            = $request->status ?? 0;
            $order->save();

            $products = $order->product_ids ? json_decode($order->product_ids, true) : [];
        
            foreach($products as $prod){
                $product = new QuotationProduct();
                $product->quotation_id          = $order->id;
                $product->product_id            = $prod['product_id'];
                $product->size                  = $prod['size'];
                $product->qty                   = $prod['qty'];
                $product->item_name             = $prod['name'];
                $product->modal_no              = $prod['modal'];
                $product->view_type             = $prod['product_type'];
                $product->start_date            = $order->commencement_date;
                $product->delivery_date         = $request->delivery_date;
                $product->revised               =  0;
                $product->status                = 1;
                $product->save();
            }

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
                $image->move(public_path('uploads/quotation/'), $imageName);
                $order->image = '/uploads/quotation/'.$imageName;

            }
            $order->revised           = $request->revised ?? 0;
            $order->status            = $request->status ?? 0;
            $order->save();

            $products = $order->product_ids ? json_decode($order->product_ids, true) : [];
            $old_products = QuotationProduct::where('id' )->where('quotation_id', $order->id)->get();
            foreach($old_products as $old_prod){
                $old_prod->delete();
            }
            foreach($products as $prod){
                $product = new QuotationProduct();
                $product->quotation_id          = $order->id;
                $product->product_id            = $prod['product_id'];
                $product->size                  = $prod['size'];
                $product->qty                   = $prod['qty'];
                $product->item_name             = $prod['name'];
                $product->modal_no              = $prod['modal'];
                $product->view_type             = $prod['product_type'];
                $product->start_date            = $order->commencement_date;
                $product->delivery_date         = $request->delivery_date;
                $product->revised               =  0;
                $product->status                = 1;
                $product->save();
            }

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
            $message = $request->message;
            $order =Quotation::find($id);

            if(!$order){
                return response()->json(['error' => 'Quotation order not found'], 404);
            }
            $order->status= $request->status;
            if($message){
                $order->remark = $message;
            }

            if($request->status == 1){
                $error = ProductionOrder::where('batch_no',$order->batch_no)->first();
                if($error){
                    return response()->json(['error' => 'Production order with this batch no already exists'], 400);
                }
                $productionOrder = new ProductionOrder();
                $productionOrder->quotation_id      = $order->id;
                $productionOrder->batch_no          = $order->batch_no;
                $productionOrder->product_ids       = $order->product_ids;
                $productionOrder->priority          = $order->priority;
                $productionOrder->customer_id       = $order->customer_id;
                $productionOrder->commencement_date = $order->commencement_date;
                $productionOrder->delivery_date     = $order->delivery_date;
                $productionOrder->sale_user_id      = $order->sale_user_id;
                $productionOrder->unique_code       = $order->unique_code;
                $productionOrder->image             = $order->image;
                $productionOrder->revised           =  0;
                $productionOrder->status            =  0;
                $productionOrder->save();

                $products = $order->product_ids ? json_decode($order->product_ids, true) : [];
                foreach($products as $prod){
                    $product = new ProductionProduct();
                    $product->po_id                 = $productionOrder->id;
                    $product->product_id            = $prod['product_id'];
                    $product->size                  = $prod['size'];
                    $product->qty                   = $prod['qty'];
                    $product->item_name             = $prod['name'];
                    $product->modal_no              = $prod['modal'];
                    $product->view_type             = $prod['product_type'];
                    $product->start_date            = $order->commencement_date;
                    $product->delivery_date         = $order->delivery_date;
                    $product->revised               =  0;
                    $product->status                = 1;
                    $product->save();


                    $viewtype = new ViewType();
                    $viewtype->po_id = $productionOrder->id ?? null;
                    $viewtype->view_type = $prod['product_type'] ?? null;
                    $viewtype->product_id = $prod['product_id'] ?? null;
                    $viewtype->status = 1;
                    $viewtype->save();
                }

            }
            $order->save();

            return response()->json(['message' => 'Quotation order status updated  successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  Quotation order', $e->getMessage()], 500);
        }
        
    }

    public function reviseQuotation(Request $request)
    {
        try{
            $id = $request->id;
            $message = $request->message;
            $order =Quotation::find($id);

            if(!$order){
                return response()->json(['error' => 'Quotation order not found'], 404);
            }
            $order->revised= !$order->revised;
            if($message){
                $order->remark = $message;
            }
            $order->save();

            return response()->json(['message' => 'Your quotation order is currently under revision']);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch  Quotation order', $e->getMessage()], 500);
        }
        
    }
    
}
