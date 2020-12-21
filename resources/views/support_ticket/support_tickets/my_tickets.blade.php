@extends('admin.default.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{translate('My Tickets')}}</h5>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control form-control-sm" placeholder="Search for...">
                        <div class="input-group-append">
                            <button class="btn btn-light" type="submit">
                                <i class="las la-search la-rotate-270"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>{{translate('Ticket ID')}}</th>
                                <th>{{translate('Subject')}}</th>
                                <th data-breakpoints="md">{{translate('Customer')}}</th>
                                <th data-breakpoints="md">{{translate('Priority')}}</th>
                                <th data-breakpoints="md">{{translate('Category')}}</th>
                                <th data-breakpoints="md">{{translate('Status')}}</th>
                                <th data-breakpoints="md">{{translate('Suport Agent')}}</th>
                                <th>{{translate('Submitted Date')}}</th>
                                <th>{{translate('Option')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($my_tickets as $key => $my_ticket)
                                <tr class="clickable-row" data-href="{{ route('support-tickets.show', encrypt($my_ticket->id)) }}">
                                    <td>{{ $my_ticket->ticket_id }} @if ($my_ticket->seen == '0') <span class="badge badge-inline badge-success float-right">{{translate('New')}}</span> @endif</td>
                                    <td>{{ $my_ticket->subject }}</td>
                                    <td>
                                        @if ($my_ticket->sender != null)
                                            {{ $my_ticket->sender->name }}
                                        @endif
                                    </td>
                                    <td class="text-capitalize">{{ $my_ticket->priority }}</td>
                                    <td>
                                        @if ($my_ticket->supportCategory != null)
                                            {{ $my_ticket->supportCategory->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (count($my_ticket->supportTicketReplies) > 0)
                                            {{ $my_ticket->supportTicketReplies->last()->created_at }}
                                        @else
                                            {{ $my_ticket->created_at }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($my_ticket->assigned_user_id != null)
                                            {{ $my_ticket->assigned->name }}
                                        @else
                                            {{translate('No Agent')}}
                                        @endif
                                    </td>
                                    <td>{{ $my_ticket->created_at }}</td>
                                    <td>
                                      <a href="{{route('support-tickets.show', encrypt($my_ticket->id))}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Reply') }}">
                                          <i class="las la-edit"></i>
                                      </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{ $my_tickets->links() }}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection
