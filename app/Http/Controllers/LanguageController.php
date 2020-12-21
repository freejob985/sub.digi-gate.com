<?php

namespace App\Http\Controllers;

use App\Rules\Lowercase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Redirect;
use Session;
use File;
use App\Models\Language;
use Symfony\Component\Console\Input\Input;
use Validator;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $rules = array();
    private $messages = array();

    public function __construct()
    {
        $this->rules = [
            'name' => [
                'required',
                'unique:languages,name',
                'max:255',
            ],
            'code' => [
                'required',
                'unique:languages,code',
                'max:2',
                new Lowercase,
            ],
        ];

        $this->messages = [
            'name.required' => __('Name is required'),
            'name.unique' => __('Name must be unique'),
            'name.max' => __('Name must less than :max characters'),
            'code.required' => __('Code is required'),
            'code.unique' => __('Code must be unique'),
            'code.max' => __('Code must less than :max characters'),

        ];
    }

    public function index()
    {
      //  dd("Catch errors for script and full tracking ( 1 )");
        $languages = Language::paginate(6);
        return view('admin.default.system_configurations.languages.index', compact('languages'));
    }

    public function changeLanguage($locale)
    {
        Session::put('locale', $locale);
        $language = Language::where('code', $locale)->first();
        flash(__('Language changed to ') . $language->name)->success();
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $language = new Language;
        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = isset($request->rtl) ? 1 : 0;
        $language->enable = 1;

        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(__('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        if ($language->save()) {
            saveJSONFile($language->code, openJSONFile('en'));
            flash(__('Language has been inserted successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('admin.default.system_configurations.languages.language_view', compact('language'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('admin.default.system_configurations.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (env("DEMO_MODE") == "On") {
            flash(__('This action is blocked in demo version!'))->error();
            return back();
        }

        $language = Language::findOrFail($id);
        $prev_code = $language->code;
        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = isset($request->rtl) ? 1 : 0;

        $rules = $this->rules;
        $rules['name'] = [
            'required',
            Rule::unique('languages')->ignore($language->id),
            'max:255'
        ];
        $rules['code'] = [
            'required',
            Rule::unique('languages')->ignore($language->id),
            'max:2',
            new Lowercase,
        ];
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(__('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        if ($language->save()) {
            saveJSONFile($language->code, openJSONFile($prev_code));

            flash(__('Language has been updated successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (env("DEMO_MODE") == "On") {
            flash(__('This action is blocked in demo version!'))->error();
            return back();
        }
        $language = Language::findOrFail($id);
        if ($language->code != env('DEFAULT_LANGUAGE')) {
            $language->delete();
            flash(__('Language has been deleted successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(__('You can not delete default language'))->error();
            return back();
        }
    }

    public function key_value_store(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $data = openJSONFile($language->code);
        foreach ($request->key as $key => $key) {
            $data[$key] = $request->key[$key];
        }
        saveJSONFile($language->code, $data);
        flash(__('Key-Value updated  for ') . $language->name)->success();
        return back();
    }


    public function update_language_status(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->enable = $request->status;
        $status_active_count = count(Language::where('enable', 1)->get());
        if ($request->status == 0) {
            if ($status_active_count == 1) {
                return 2;
            }
        }
        if ($language->save()) {
            return 1;
        }
        return 0;
    }
}
