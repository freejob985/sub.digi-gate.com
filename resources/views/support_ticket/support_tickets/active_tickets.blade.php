@extends('admin.default.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{translate('All Active Tickets')}}</h5>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>{{translate('Ticket')}}</th>
                            <th>{{translate('Subject')}}</th>
                            <th data-breakpoints="md">{{translate('Customer')}}</th>
                            <th data-breakpoints="sm">{{translate('Priority')}}</th>
                            <th data-breakpoints="md">{{translate('Category')}}</th>
                            <th data-breakpoints="md">{{translate('Suport Agent')}}</th>
                            <th data-breakpoints="sm">{{translate('Submitted Date')}}</th>
                            <th class="text-center" width="10%">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($support_tickets as $key => $support_ticket)
                            <tr class="clickable-row" data-href="{{ route('support-tickets.show', encrypt($support_ticket->id)) }}">
                                <td>{{ $support_ticket->ticket_id }} @if ($support_ticket->seen == '0') <span class="badge badge-inline badge-success float-right">{{translate('New')}}</span> @endif</td>
                                <td>{{ $support_ticket->subject }}</td>
                                <td>{{ $support_ticket->sender->name }}</td>
                                <td class="text-capitalize">{{ $support_ticket->priority }}</td>
                                <td>{{ $support_ticket->supportCategory->name }}</td>
                                <td>
                                    @if ($support_ticket->assigned_user_id != null)
                                        {{ $support_ticket->assigned->name }}
                                    @else
                                        {{translate('No Agent')}}
                                    @endif
                                </td>
                                <td>{{ $support_ticket->created_at }}</td>
                                <td>
                                    <a class="dropdown-item btn btn-soft-primary" href="{{ route('support-tickets.edit', encrypt($support_ticket->id)) }}"><i class="la la-mercury"></i>{{translate('Assign an Agent')}}</a>
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

@endsection
