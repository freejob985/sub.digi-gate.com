<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\Setting;
use App\State;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        /**
         * Start SEO
         */
        $settings = Setting::find(1);
        //SEOMeta::setTitle('Dashboard - States - ' . (empty($settings->setting_site_name) ? config('app.name', 'Laravel') : $settings->setting_site_name));
        SEOMeta::setTitle(__('seo.backend.admin.state.states', ['site_name' => empty($settings->setting_site_name) ? config('app.name', 'Laravel') : $settings->setting_site_name]));
        SEOMeta::setDescription('');
        SEOMeta::setCanonical(URL::current());
        SEOMeta::addKeyword($settings->setting_site_seo_home_keywords);
        /**
         * End SEO
         */

        $country_id = $request->country;

        if($country_id)
        {
            $country = Country::findOrFail($country_id);

            $all_states = $country->states()->orderBy('state_name')->get();
        }
        else
        {
            $all_states = State::orderBy('state_name')->get();
        }

        $all_countries = Country::orderBy('country_name')->get();

        return response()->view('backend.admin.state.index',
            compact('all_countries', 'country_id', 'all_states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        /**
         * Start SEO
         */
        $settings = Setting::find(1);
        //SEOMeta::setTitle('Dashboard - Create State - ' . (empty($settings->setting_site_name) ? config('app.name', 'Laravel') : $settings->setting_site_name));
        SEOMeta::setTitle(__('seo.backend.admin.state.create-state', ['site_name' => empty($settings->setting_site_name) ? config('app.name', 'Laravel') : $settings->setting_site_name]));
        SEOMeta::setDescription('');
        SEOMeta::setCanonical(URL::current());
        SEOMeta::addKeyword($settings->setting_site_seo_home_keywords);
        /**
         * End SEO
         */

        $all_countries = Country::orderBy('country_name')->get();
        return response()->view('backend.admin.state.create', compact('all_countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|numeric',
            'state_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'state_abbr' => 'required|max:255',
        ]);

        $country = Country::find($request->country_id);

        if($country)
        {
            $state_name = ucwords(strtolower($request->state_name));
            $state_abbr = strtoupper($request->state_abbr);
            $state_slug = str_slug($request->state_name);
            $state_country_abbr = $country->country_abbr;

            $validate_error = array();
            $state_name_exist = $country->states()
                ->where('state_name', $state_name)
                ->get()->count();
            if($state_name_exist > 0)
            {
                $validate_error['state_name'] = 'State name has been taken.';
            }
            $state_abbr_exist = $country->states()
                ->Where('state_abbr', $state_abbr)
                ->get()->count();
            if($state_abbr_exist > 0)
            {
                $validate_error['state_abbr'] = 'State abbr has been taken.';
            }

            if(count($validate_error) > 0)
            {
                throw ValidationException::withMessages($validate_error);
            }
            else
            {
                // now can store
                $new_state = new State(array(
                    'state_name' => $state_name,
                    'state_abbr' => $state_abbr,
                    'state_slug' => $state_slug,
                    'state_country_abbr' => $state_country_abbr
                ));

                $created_state = $country->states()->save($new_state);

                \Session::flash('flash_message', __('alert.state-created'));
                \Session::flash('flash_type', 'success');

                return redirect()->route('admin.states.edit', $created_state->id);
            }
        }
        else
        {
            throw ValidationException::withMessages(['country_id' => 'Country not found']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param State $state
     */
    public function show(State $state)
    {
        return redirect()->route('admin.states.edit', $state);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param State $state
     * @return Response
     */
    public function edit(State $state)
    {
        /**
         * Start SEO
         */
        $settings = Setting::find(1);
        //SEOMeta::setTitle('Dashboard - Edit State - ' . (empty($settings->setting_site_name) ? config('app.name', 'Laravel') : $settings->setting_site_name));
        SEOMeta::setTitle(__('seo.backend.admin.state.edit-state', ['site_name' => empty($settings->setting_site_name) ? config('app.name', 'Laravel') : $settings->setting_site_name]));
        SEOMeta::setDescription('');
        SEOMeta::setCanonical(URL::current());
        SEOMeta::addKeyword($settings->setting_site_seo_home_keywords);
        /**
         * End SEO
         */

        return response()->view('backend.admin.state.edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param State $state
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, State $state)
    {
        $request->validate([
            'country_id' => 'required|numeric',
            'state_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'state_abbr' => 'required|max:255',
        ]);

        $country = Country::find($request->country_id);

        if($country)
        {
            $state_name = ucwords(strtolower($request->state_name));
            $state_abbr = strtoupper($request->state_abbr);
            $state_slug = str_slug($request->state_name);

            $validate_error = array();
            $state_name_exist = $country->states()
                ->where('state_name', $state_name)
                ->where('id', '!=', $state->id)
                ->get()->count();
            if($state_name_exist > 0)
            {
                $validate_error['state_name'] = 'State name has been taken.';
            }
            $state_abbr_exist = $country->states()
                ->Where('state_abbr', $state_abbr)
                ->where('id', '!=', $state->id)
                ->get()->count();
            if($state_abbr_exist > 0)
            {
                $validate_error['state_abbr'] = 'State abbr has been taken.';
            }
            if(count($validate_error) > 0)
            {
                throw ValidationException::withMessages($validate_error);
            }
            else
            {
                $state->state_name = $state_name;
                $state->state_abbr = $state_abbr;
                $state->state_slug = $state_slug;
                $state->save();

                \Session::flash('flash_message', __('alert.state-updated'));
                \Session::flash('flash_type', 'success');

                return redirect()->route('admin.states.edit', $state);
            }
        }
        else
        {
            throw ValidationException::withMessages(['country_id' => 'Country not found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param State $state
     */
    public function destroy(State $state)
    {
        // check model relations before delete
        if($state->cities()->get()->count() > 0)
        {
            \Session::flash('flash_message', __('alert.state-delete-error-city'));
            \Session::flash('flash_type', 'danger');

            return redirect()->route('admin.states.edit', $state);
        }
        elseif($state->items()->get()->count() > 0)
        {
            \Session::flash('flash_message', __('alert.state-delete-error-listing'));
            \Session::flash('flash_type', 'danger');

            return redirect()->route('admin.states.edit', $state);
        }
        else
        {
            $state->delete();

            \Session::flash('flash_message', __('alert.state-deleted'));
            \Session::flash('flash_type', 'success');

            return redirect()->route('admin.states.index');
        }
    }
}
