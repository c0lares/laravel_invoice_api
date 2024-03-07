<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InvoiceResource::collection(Invoice::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1|in:P,B,C',
            'paid'=> 'required|numeric|between:0,1',
            'payment_date'=> 'nullable',
            'value' => 'required|numeric|between:1,9999,99'
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $paid = $request->paid;
        if ($paid == 1) {
            $request->merge(['payment_date' => Carbon::now()->toDateTimeString()]);
        } 

        return Invoice::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        
        $invoice = Invoice::with('user')->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){

        $invoice = Invoice::findOrFail($id);
        if($request->paid){
            $request->merge(['payment_date' => Carbon::now()->toDateTimeString()]);
        }
        $invoice->update($request->all());
        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return Invoice::all();
    }
}
