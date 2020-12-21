<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use Gate;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('freelancer_skill_index')) {
            $skills = Skill::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.default.skills.index', compact('skills'));
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
        $skill = new Skill;
        $skill->name = $request->name;
        if ($skill->save()) {
            flash('New Skill has been inserted successfully')->success();
            return redirect()->route('skills.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
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
        if (Gate::allows('freelancer_skill_edit')) {
            $skill = Skill::findOrFail(decrypt($id));
            return view('admin.default.skills.edit', compact('skill'));
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
        $skill = Skill::findOrFail($id);
        $skill->name = $request->name;
        if ($skill->save()) {
            flash('Skill has been Updated successfully')->success();
            return redirect()->route('skills.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
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
        if (Gate::allows('freelancer_skill_delete')) {
            $skill = Skill::findOrFail($id);
            if(Skill::destroy($id)){
                flash('Skill Info has been deleted successfully')->success();
                return redirect()->route('skills.index');
            }
            else {
                flash('Sorry! Something went wrong.')->error();
                return back();
            }
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }
}
