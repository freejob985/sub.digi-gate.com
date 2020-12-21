<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use Redirect,Response;
use Gate;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('currency_index')) {
            $currencies = Currency::all();
            return view('admin.default.system_configurations.currencies.index', compact('currencies'));
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('currency_create')) {
            return view('admin.default.system_configurations.currencies.create');
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currency = new Currency;
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        if ($currency->save()) {
            flash(__('Currency has been inserted successfully'))->success();
            return redirect()->route('currencies.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
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
        if (Gate::allows('currency_edit')) {
            $currency = Currency::findOrFail(decrypt($id));
            return view('admin.default.system_configurations.currencies.edit', compact('currency'));
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
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
        $currency = Currency::findOrFail($id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        if ($currency->save()) {
            flash(__('Currency has been updated successfully'))->success();
            return redirect()->route('currencies.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('currency_delete')) {
            $currency = Currency::findOrFail($id);
            if(Currency::destroy($id)){
                flash(__('Currency has been deleted successfully'))->success();
                return redirect()->route('currencies.index');
            }

            flash(__('Something went wrong'))->error();
            return back();
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }

    public function set_currency()
    {
        if (Gate::allows('currency_configuration')) {
            $currencies = Currency::all();
            return view('admin.default.system_configurations.currencies.set_currency', compact('currencies'));
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }
}
