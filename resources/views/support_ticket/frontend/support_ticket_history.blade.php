
@extends('frontend.default.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @if (\App\Models\Role::find(Session::get('role_id'))->name == 'Client')
                    @include('frontend.default.user.client.inc.sidebar')
                @elseif (\App\Models\Role::find(Session::get('role_id'))->name == 'Freelancer')
                    @include('frontend.default.user.freelancer.inc.sidebar')
                @endif

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Support Tickets') }}</h1>
                            </div>
							<div class="col-md-6 text-md-right">
								<a href="{{ route('support-tickets.user_ticket_create') }}" class="btn btn-primary">
									<i class="las la-plus"></i>
									<span>{{ translate('Create New Ticket') }}</span>
								</a>
							</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header row gutters-5">
                            <div class="col text-center text-md-left">
                              <h5 class="mb-md-0 h6">{{ translate('All Tickets') }}</h5>
                            </div>
                              <div class="col-md-3 ml-auto">
                                <select class="form-control aiz-selectpicker" name="delivery_status" id="delivery_status" onchange="sort_orders()">
                                    <option value="showCategoryByFilterSelect1" selected>All</option>
                                    <option value="showCategoryByFilterSelect2">Pending</option>
                                    <option value="showCategoryByFilterSelect2">Opened</option>
                                    <option value="showCategoryByFilterSelect3">Solved</option>
                                </select>
                              </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-light">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ translate('ID') }}</th>
                                        <th scope="col">{{ translate('Status') }}</th>
                                        <th scope="col">{{ translate('Subject') }}</th>
                                        <th scope="col">{{ translate('Category') }}</th>
                                        <th scope="col">{{ translate('Created at') }}</th>
                                        <th scope="col">{{ translate('New Reply') }}</th>
                                        <th scope="col">{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($support_tickets as $key => $support_ticket)
                                        <tr>
                                            <th scope="row">{{$support_ticket->ticket_id}}</th>
                                            <td scope="row">
                                                @if ($support_ticket->status == '1')
                                                    <span class="badge badge-inline badge-success">{{__('Solved')}}</span>
                                                @else
                                                    <span class="badge badge-inline badge-danger">{{__('Pending')}}</span>
                                                @endif
                                            </td>
                                            <td scope="row">{{$support_ticket->subject}}</td>
                                            <td  scope="row" class="text-secondary">{{$support_ticket->supportCategory->name}}</td>
                                            <td class="text-secondary">{{$support_ticket->created_at}}</td>
                                            <td class="text-primary">0</td>
                                            <td scope="row">
                                                <a class="btn btn-xs btn-soft-primary" href="{{ route('support-tickets.user_view_details', encrypt($support_ticket->id)) }}">{{ translate('View details') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{ $support_tickets->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
