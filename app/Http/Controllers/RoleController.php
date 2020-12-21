<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\UserRole;
use Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('role_index')) {
            $roles = Role::paginate(9);
            return view('admin.default.roles.index', compact('roles'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role;
        $role->role_type = 'employee';
        $role->name = $request->name;
        if($role->save()){
            flash(__('Role has been inserted successfully'))->success();
            return redirect()->route('roles.index');
        }
        else {
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
        if (Gate::allows('role_edit')) {
            $role = Role::findOrFail(decrypt($id));
            return view('admin.default.roles.edit', compact('role'));
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
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        if($role->save()){
            flash(__('Role has been updated successfully'))->success();
            return redirect()->route('roles.index');
        }
        else {
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
        if (Gate::allows('role_delete')) {
            if(Role::destroy($id)){
                flash(__('Role has been deleted successfully'))->success();
                return redirect()->route('roles.index');
            }
            else{
                flash(__('Something went wrong'))->error();
                return back();
            }
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }
}
