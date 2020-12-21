<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManualPaymentMethod;

class ManualPaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manual_payment_methods = ManualPaymentMethod::orderBy('created_at', 'desc')->get();
        return view('manual_payment.payment_methods.index', compact('manual_payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
         return view('manual_payment.payment_methods.create');
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
         $manual_payment_method                 = new ManualPaymentMethod;
         $manual_payment_method->type           = $request->type;
         $manual_payment_method->photo          = $request->photo;
         $manual_payment_method->heading        = $request->heading;
         $manual_payment_method->description    = $request->description;

         if($request->type == 'bank_payment')
         {
             $banks_informations = array();
             for ($i=0; $i < count($request->bank_name); $i++) {
                 $item                      = array();
                 $item['bank_name']         = $request->bank_name[$i];
                 $item['account_name']      = $request->account_name[$i];
                 $item['account_number']    = $request->account_number[$i];
                 $item['routing_number']    = $request->routing_number[$i];
                 array_push($banks_informations, $item);
             }

             $manual_payment_method->bank_info = json_encode($banks_informations);
         }
         $manual_payment_method->save();

         flash(translate('New Payment Method has been inserted successfully'))->success();
         return redirect()->route('manual_payment_methods.index');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
         $manual_payment_method = ManualPaymentMethod::findOrFail(decrypt($id));
         return view('manual_payment.payment_methods.edit', compact('manual_payment_method'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
     {
         $manual_payment_method = ManualPaymentMethod::findOrFail($id);
         $manual_payment_method->type = $request->type;
         $manual_payment_method->heading = $request->heading;
         $manual_payment_method->description = $request->description;
         $manual_payment_method->photo = $request->photo;;

         if($request->type == 'bank_payment')
         {
             $banks_informations = array();
             for ($i=0; $i < count($request->bank_name); $i++) {
                 $item = array();
                 $item['bank_name'] = $request->bank_name[$i];
                 $item['account_name'] = $request->account_name[$i];
                 $item['account_number'] = $request->account_number[$i];
                 $item['routing_number'] = $request->routing_number[$i];
                 array_push($banks_informations, $item);
             }

             $manual_payment_method->bank_info = json_encode($banks_informations);
         }
         $manual_payment_method->save();

         flash( translate('Payment Method has been updated successfully'))->success();
         return redirect()->route('manual_payment_methods.index');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(ManualPaymentMethod::destroy($id)){
            flash(translate('Payment Method has been deleted successfully'))->success();
        }
        else{
            flash(translate('Something went wrong'))->error();
        }
        return redirect()->route('manual_payment_methods.index');
    }

    public function get_offline_package_purchase_modal(Request $request)
    {
        $package_id =  $request->package_id;
        return view('manual_payment.frontend.offline_package_purchase_modal', compact('package_id'));
    }

    public function get_offline_service_package_purchase_modal(Request $request)
    {
        $service_package_id =  $request->service_package_id;
        return view('manual_payment.frontend.offline_service_package_purchase_modal', compact('service_package_id'));
    }

    public function get_offline_milestone_payment_modal(Request $request)
    {
        $milestone_payment_id =  $request->milestone_payment_id;
        return view('manual_payment.frontend.offline_milestone_payment_modal', compact('milestone_payment_id'));
    }

}
