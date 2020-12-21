@extends('admin.default.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="project_payments" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Offline Project Payments')}}</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by project name" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset>
                            <div class="input-group-append">
                                <button class="btn btn-light" type="submit">
                                    <i class="las la-search la-rotate-270"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Project') }}</th>
                            <th data-breakpoints="md">{{ translate('Client') }}</th>
                            <th data-breakpoints="md">{{ translate('Freelancer') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th data-breakpoints="sm">{{ translate('My Earnings') }}</th>
                            <th data-breakpoints="sm">{{ translate('Freelancer Earnings') }}</th>
                            <th>{{ translate('Payment method') }}</th>
                            <th data-breakpoints="md">{{ translate('TXN ID') }}</th>
                            <th data-breakpoints="sm">{{ translate('Receipt') }}</th>
                            <th data-breakpoints="sm">{{ translate('Date') }}</th>
                            <th class="text-right">{{ translate('Approval') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($milestone_payments as $key => $milestone_payment_id)
                            @php
                                $milestone_payment = \App\Models\MilestonePayment::find($milestone_payment_id->id);
                            @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $milestone_payment->project->name }}</td>
                                <td>{{ $milestone_payment->client->name }}</td>
                                <td>{{ $milestone_payment->freelancer->name }}</td>
                                <td>{{ single_price($milestone_payment->amount) }}</td>
                                <td>{{ single_price($milestone_payment->admin_profit) }}</td>
                                <td>{{ single_price($milestone_payment->freelancer_profit) }}</td>
                                <td>
                                  <span class="badge badge-inline badge-success">
                                    {{ $milestone_payment->payment_method }}
                                  </span>
                                </td>
                                <td>{{ $milestone_payment->payment_details }}</td>
                                <td>
                                  @if ($milestone_payment->receipt != null)
                                      <a href="{{ custom_asset($milestone_payment->receipt) }}" target="_blank">{{translate('Open Reciept')}}</a>
                                  @endif
                                </td>
                                <td>{{ $milestone_payment->created_at }}</td>
                                <td class="text-right">
                                    @if($milestone_payment->approval == 1)
                                        <span class="badge badge-inline badge-success">{{ translate('Approved')}}</span>
                                    @else
                                        <a href="javascript:void(0)" data-target="#offline_project_payment_approval_modal" data-href="{{route('offline_project_payment.approve', $milestone_payment->id)}}" class="btn btn-sm btn-primary confirm-alert">{{ translate('Approve')}}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $milestone_payments->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')

    <!-- Offline Project Payment Approval modal -->
    <div class="modal fade" id="offline_project_payment_approval_modal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title h6">{{ translate('Offline Project Payment Request Approve')}}</h5>
            <button type="button" class="close" data-dismiss="modal">
            </button>
          </div>
          <div class="modal-body">
            <p>{{translate('Are you sure, You want to approve this payment?')}}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
            <a href="#" id="link" class="btn btn-primary comfirm-link">{{ translate('Approve') }}</a>
          </div>
        </div>
      </div>
    </div>

@endsection
