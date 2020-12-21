<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServicePackage;
use App\Models\ServicePackagePayment;
use App\Utility\ServicesUtility;
use App\Utility\ValidationUtility;
use Illuminate\Http\Request;
use Auth;
use Validator;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->rules = ValidationUtility::get_service_validation_rules();
        $this->messages = ValidationUtility::get_service_validation_message();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.default.user.freelancer.projects.services.index');
    }

    public function freelancer_index()
    {
        $services = Auth::user()->services()->paginate(12);
        return view('frontend.default.user.freelancer.projects.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(ServicesUtility::can_create_service() == 1)
            return view('frontend.default.user.freelancer.projects.services.create');

        flash(translate('Sorry! Your service creation limit is over.'))->warning();

        return redirect()->route('service.freelancer_index');
    }

    public function validate_service($request)
    {
        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return 0;
        }

        return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(ServicesUtility::can_create_service() != 1) {
            flash(translate('Sorry! Your service creation limit is over.'))->warning();
            return redirect()->route('service.freelancer_index');
        }

        if(!$this->validate_service($request)) {
            flash(translate('Sorry! Your validation was not successful.'))->error();
            return redirect(route('service.create'));
        }

        $service_created = ServicesUtility::create_service($request);

        if($service_created == 1) {
            flash(translate('Service saved successfully'))->success();
            return redirect(route('service.freelancer_index'));
        }

        flash(translate('Service was not saved successfully. Please try again.'))->error();
        return redirect()->route('service.freelancer_index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $service = Service::where('slug', $slug)->first();
        if($service != null){
            $service_packages = $service->service_packages;

            return view('frontend.default.services-single', compact('service', 'service_packages'));
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $service = Service::where('slug', $slug)->first();
        $service_packages = $service->service_packages;

        return view('frontend.default.user.freelancer.projects.services.edit', compact('service', 'service_packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        if(!$this->validate_service($request)) {
            flash(translate('Sorry! Your validation was not successful.'))->error();
            return redirect(route('service.edit', $slug));
        }

        $service_updated = ServicesUtility::update_service($request, $slug);

        if($service_updated == 1) {
            flash(translate('Service updated successfully'))->success();
            return redirect(route('service.freelancer_index'));
        }

        flash(translate('Service was not updated successfully. Please try again.'))->error();
        return redirect()->route('service.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $service = Service::where('slug', $slug)->first();
        $service_packages = $service->service_packages;

        $deleted_success = ServicesUtility::delete_service($slug);

        if($deleted_success == 1) {
            flash(translate('Service successfully deleted.'))->success();
        } else {
            flash(translate('Service was not successfully deleted.'))->error();
        }

        return redirect()->route('service.freelancer_index');
    }

    public function get_service_package_purchase_modal(Request $request)
    {
        $service_package = ServicePackage::findOrFail($request->id);
        return view('service_purchase_modal', compact('service_package'));
    }

    public function purchase_service_package(Request $request)
    {
        $service_package = ServicePackage::findOrFail($request->service_package_id);
        $data['service_package_id'] = $service_package->id;
        $data['payment_method'] = $request->payment_option;
        $data['amount'] = $service_package->service_price;
        $data['user_id'] = Auth::user()->id;
        $data['payment_type'] = 'service_payment';
        $request->session()->put('payment_data', $data);

        if($request->payment_option == 'paypal'){
            $paypal = new PayPalController;
            return $paypal->getCheckout();
        }
        elseif ($request->payment_option == 'stripe') {
            $stripe = new StripePaymentController;
            return $stripe->index();
        }
        elseif ($request->payment_option == 'sslcommerz') {
            $sslcommerz = new PublicSslCommerzPaymentController;
            return $sslcommerz->index($request);
        }
        elseif ($request->payment_option == 'paystack') {
            $paystack = new PaystackController;
            return $paystack->redirectToGateway($request);
        }
        elseif ($request->payment_option == 'instamojo') {
            $instamojo = new InstamojoController;
            return $instamojo->pay($request);
        }
        elseif ($request->payment_option == 'paytm') {
            $paytm = new PaytmController;
            return $paytm->index();
        }
    }

    public function sold_services()
    {
        $this->middleware('freelancer');
        $purchasedServices = ServicePackagePayment::where('service_owner_id', Auth::user()->id)->latest()->paginate(12);
        return view('frontend.default.user.freelancer.projects.services.purchased', compact('purchasedServices'));
    }

    public function client_purchased_services()
    {
        $this->middleware('client');
        $purchasedServices = ServicePackagePayment::where('user_id', Auth::user()->id)->latest()->paginate(12);
        return view('frontend.default.user.client.services.purchased', compact('purchasedServices'));
    }

    public function admin_all_services()
    {
        $this->middleware('admin');
        $services = Service::latest()->paginate(12);
        return view('admin.default.services.index', compact('services'));
    }
}
