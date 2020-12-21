<?php

namespace App\Http\Controllers;

use App\Http\Responses\BadgeStoreResponse;
use App\Http\Responses\BadgeUpdateResponse;
use App\Models\Country;
use App\Repositories\Badge\BadgeInterface;
use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\Role;
use Gate;

class BadgeController extends Controller
{
    protected $repository;

    public function __construct(BadgeInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        if (Gate::allows('freelancer_badge_index')) {
            list($badges, $role) = $this->repository->getBadgesAndRole('Freelancer', 2);
            return view('admin.default.freelancer_badges.index', compact('badges','role'));
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
        // return Country::all();
    }

    public function client_badges_index()
    {
        if (Gate::allows('client_badge_index')) {
            list($badges, $role) = $this->repository->getBadgesAndRole('Client', 3);
            return view('admin.default.client_badges.index', compact('badges','role'));
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }

    public function create()
    {
        // $role = $this->repository->getBadgesAndRole('Freelancer');
        // return view('admin.default.freelancer_badges.create', compact('role'));
    }

    public function client_badges_create()
    {
        // $role = $this->repository->getBadgesAndRole('Client');
        // return view('admin.default.client_badges.create', compact('role'));
    }

    public function store(Request $request)
    {
        return new BadgeStoreResponse($request, $this->repository);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if (Gate::allows('freelancer_badge_edit')) {
            $badge = $this->repository->getById(decrypt($id));
            return view('admin.default.freelancer_badges.edit', compact('badge'));
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }

    public function client_badges_edit($id)
    {
        if (Gate::allows('client_badge_edit')) {
            $badge = $this->repository->getById(decrypt($id));
            return view('admin.default.client_badges.edit', compact('badge'));
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        return new BadgeUpdateResponse($request, $this->repository, $id);
    }

    public function destroy($id)
    {
        if (Gate::allows('freelancer_badge_delete') || Gate::allows('client_badge_delete')) {
            $this->repository->delete($id);
            flash('Badge has been deleted successfully')->success();
            return back();
        }
        else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }
}
