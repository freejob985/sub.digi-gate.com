<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemConfiguration;
use Paypal;
use Redirect;
use Session;

class PayPalController extends Controller
{

    private $_apiContext;

    public function __construct()
    {
        if(SystemConfiguration::where('type', 'paypal_sandbox_checkbox')->first()->value == 1){
            $mode = 'sandbox';
            $endPoint = 'https://api.sandbox.paypal.com';
        }
        else{
            $mode = 'live';
            $endPoint = 'https://api.paypal.com';
        }
        $this->_apiContext = PayPal::ApiContext(
            env('PAYPAL_CLIENT_ID'),
            env('PAYPAL_CLIENT_SECRET'));

        $this->_apiContext->setConfig(array(
            'mode' => $mode,
            'service.EndPoint' => $endPoint,
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => public_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));
    }

    public function getCheckout()
    {
    	$payer = PayPal::Payer();
    	$payer->setPaymentMethod('paypal');
    	$amount = PayPal::Amount();
    	$amount->setCurrency('USD');

        if(Session::get('payment_data')['payment_type'] == 'package_payment'){
            $amount->setTotal(Session::get('payment_data')['amount']);
            $description = 'Payment for package';
        }
        elseif (Session::get('payment_type') == 'milestone_payment') {
            $amount->setTotal(Session::get('payment_data')['amount']);
            $description = 'Payment for milestone';
        }
        elseif (Session::get('payment_data')['payment_type'] == 'service_payment') {
            $amount->setTotal(Session::get('payment_data')['amount']);
            $description = 'Payment for purchasing Freelancer Package';
        }
    	// This is the simple way,
    	// you can alternatively describe everything in the order separately;
    	// Reference the PayPal PHP REST SDK for details.
    	$transaction = PayPal::Transaction();
    	$transaction->setAmount($amount);
    	$transaction->setDescription($description);
    	$redirectUrls = PayPal:: RedirectUrls();
    	$redirectUrls->setReturnUrl(url('paypal/payment/done'));
    	$redirectUrls->setCancelUrl(url('paypal/payment/cancel'));
    	$payment = PayPal::Payment();
    	$payment->setIntent('sale');
    	$payment->setPayer($payer);
    	$payment->setRedirectUrls($redirectUrls);
    	$payment->setTransactions(array($transaction));
    	$response = $payment->create($this->_apiContext);
    	$redirectUrl = $response->links[1]->href;

    	return Redirect::to( $redirectUrl );
    }


    public function getCancel(Request $request)
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        $request->session()->forget('payment_data');
        flash(__('Payment cancelled'))->success();
    	return redirect()->route('dashboard');
    }

    public function getDone(Request $request)
    {
    	$payment_id = $request->get('paymentId');
    	$token = $request->get('token');
    	$payer_id = $request->get('PayerID');

        if(SystemConfiguration::where('type', 'paypal_sandbox_checkbox')->first()->value == 1){
            $mode = 'sandbox';
            $endPoint = 'https://api.sandbox.paypal.com';
        }
        else{
            $mode = 'live';
            $endPoint = 'https://api.paypal.com';
        }
        $this->_apiContext = PayPal::ApiContext(
            env('PAYPAL_CLIENT_ID'),
            env('PAYPAL_CLIENT_SECRET'));

        $this->_apiContext->setConfig(array(
            'mode' => $mode,
            'service.EndPoint' => $endPoint,
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => public_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));

        $payment = PayPal::getById($payment_id, $this->_apiContext);
        $paymentExecution = PayPal::PaymentExecution();
        $paymentExecution->setPayerId($payer_id);
        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        $payment = json_encode(['id' => $executePayment->id]);

        if(Session::get('payment_data')['payment_type'] == 'package_payment'){
            $package_payment = new PackagePaymentController;
            return $package_payment->package_payment_done($request->session()->get('payment_data'), $payment);
        }
        elseif (Session::get('payment_type') == 'milestone_payment') {
            $milestone_payment = new MilestonePaymentController;
            return $milestone_payment->milestone_payment_done($request->session()->get('payment_data'), $payment);
        }
        elseif (Session::get('payment_data')['payment_type'] == 'service_payment') {
            $package_payment = new ServicePaymentController;
            return $package_payment->service_package_payment_done(Session::get('payment_data'), json_encode($payment));
        }
    }

}
