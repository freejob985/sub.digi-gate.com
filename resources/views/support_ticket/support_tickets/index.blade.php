@extends('admin.default.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{translate('Support Ticket Info')}}
                    <a href="{{ route('support_tickets.create') }}" class="btn btn-success btn-sm ml-3">{{translate('Add New Ticket')}}</a></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{translate('Subject')}}</th>
                        <th>{{translate('Customer')}}</th>
                        <th>{{translate('Priority')}}</th>
                        <th>{{translate('Category')}}</th>
                        <th>{{translate('Suport Agent')}}</th>
                        <th>{{translate('Submitted Date')}}</th>
                        <th width="10%">{{translate('Option')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($support_tickets as $key => $support_ticket)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $support_ticket->subject }} @if ($support_ticket->view == '0') <span class="badge badge-success float-right">New</span> @endif</td>
                            <td>{{ $support_ticket->user_id }}</td>
                            <td>{{ $support_ticket->support_priority->name }}</td>
                            <td>{{ $support_ticket->support_category->name }}</td>
                            <td>{{ $support_ticket->staff->user->name }}</td>
                            <td>{{ $support_ticket->created_at }}</td>
                            <td>
                                <div class="btn-group mb-2">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> {{translate('Actions')}} <span class="caret"></span> </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('support_tickets.edit', encrypt($support_ticket->id)) }}">{{translate('Edit')}}</a>
                                            <a class="dropdown-item" href="{{ route('support_tickets.show', encrypt($support_ticket->id)) }}">{{translate('Show')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
