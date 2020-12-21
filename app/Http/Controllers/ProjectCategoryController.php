<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use App\Utility\CategoryUtility;
use Illuminate\Support\Str;
use Gate;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('project_cat_index')) {
            $project_categories = ProjectCategory::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.default.project_categories.index', compact('project_categories'));
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
        // dd($request->parent_id);
        $project_category = new ProjectCategory;
        $project_category->name = $request->name;
        if ($request->parent_id != null) {
            $project_category->parent_id = $request->parent_id;
        }
        if($request->hasFile('image')){
            $project_category->photo = $request->file('image')->store('uploads/project_category_photo');
        }
        $project_category->slug = Str::slug($request->name, '-').'-'.Str::random(5);
        if($project_category->save()){
            flash(__('New Category has been added successfully!'))->success();
            return redirect()->route('project-categories.index');
        }
        else {
            flash(__('Something went wrong!'))->warning();
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
        if (Gate::allows('project_cat_edit')) {
            $project_category = ProjectCategory::findOrFail(decrypt($id));
            $project_categories = ProjectCategory::whereNotIn('id',CategoryUtility::children_ids($project_category->id,true))->where('id', '!=' , $project_category->id)->get();
            return view('admin.default.project_categories.edit', compact('project_category', 'project_categories'));
        }
        else {
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
        $project_category = ProjectCategory::findOrFail($id);
        $project_category->name = $request->name;
        if ($request->parent_id != null) {
            $project_category->parent_id = $request->parent_id;
        }
        $project_category->slug = Str::slug($request->name, '-').'-'.Str::random(5);
        if($request->hasFile('image')){
            $project_category->photo = $request->file('image')->store('uploads/project_category_photo');
        }
        if($project_category->save()){
            flash(__('New Category has been updated successfully!'))->success();
            return redirect()->route('project-categories.index');
        }
        else {
            flash(__('Something went wrong!'))->warning();
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
        if (Gate::allows('project_cat_delete')) {
            CategoryUtility::delete_category(decrypt($id));
            flash(__('Category deleted'))->success();
            return redirect()->route('project-categories.index');
        }
        else {
            flash(__('Something went wrong!'))->warning();
            return back();
        }
    }
}
