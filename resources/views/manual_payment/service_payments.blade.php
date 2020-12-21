@extends('admin.default.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="service_payments_history" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Manual Service Payment History')}}</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="aiz-date-range form-control" @isset($sort_search) value="{{ $sort_search }}" @endisset name="date" placeholder="{{ translate('Select time and Search') }}" data-advanced-range="true" autocomplete="off"/>
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
                            <th width="15%">{{ translate('Service') }}</th>
                            <th data-breakpoints="sm">{{ translate('Service Type') }}</th>
                            <th data-breakpoints="md">{{ translate('Client') }}</th>
                            <th data-breakpoints="md">{{ translate('Freelancer') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th data-breakpoints="sm">{{ translate('My Earnings') }}</th>
                            <th data-breakpoints="sm">{{ translate('Freelancer Earnings') }}</th>
                            <th>{{ translate('Payment Method') }}</th>
                            <th data-breakpoints="sm">{{ translate('TXN ID') }}</th>
                            <th>{{ translate('receipt') }}</th>
                            <th>{{ translate('Date') }}</th>
                            <th class="text-right">{{ translate('Approval') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service_payments as $key => $service_payment)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><a target="_blank" href="{{ route('service.show', $service_payment->servicePackage->service->slug) }}">{{ $service_payment->servicePackage->service->title }}</a></td>
                                <td>{{ ucfirst($service_payment->servicePackage->service_type) }}</td>
                                <td>{{ $service_payment->user->name }}</td>
                                <td>{{ $service_payment->freelancer->name }}</td>
                                <td>{{ single_price($service_payment->amount) }}</td>
                                <td>{{ single_price($service_payment->admin_profit) }}</td>
                                <td>{{ single_price($service_payment->freelancer_profit) }}</td>
                                <td>
                                    <span class="badge badge-inline badge-success">{{ $service_payment->payment_method }}</span>
                                </td>
                                <td>{{ $service_payment->payment_details }}</td>
                                <td>
                                  @if ($service_payment->receipt != null)
                                      <a href="{{ custom_asset($service_payment->receipt) }}" target="_blank">{{translate('Open Reciept')}}</a>
                                  @endif
                                </td>
                                <td>{{ $service_payment->created_at }}</td>
                                <td class="text-right">
                                    @if($service_payment->approval == 1)
                                        <span class="badge badge-inline badge-success">{{ translate('Approved')}}</span>
                                    @else
                                        <a href="javascript:void(0)" data-target="#offline_service_payment_approval_modal" data-href="{{route('offline_service_payment.approve', $service_payment->id)}}" class="btn btn-sm btn-primary confirm-alert">{{ translate('Approve')}}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    {{ $service_payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    <!-- Offline Package Payment Approval modal -->
    <div class="modal fade" id="offline_service_payment_approval_modal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h6">{{ translate('Offline Package Payment Request Approve')}}</h5>
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
