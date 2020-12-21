@extends('admin.default.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="package_payments_history" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{translate('Manual Package Payment History')}}</h5>
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
                            <th>{{ translate('Package Name') }}</th>
                            <th data-breakpoints="sm">{{ translate('Package Type') }}</th>
                            <th data-breakpoints="sm">{{ translate('User') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th data-breakpoints="sm">{{ translate('Payment Method') }}</th>
                            <th data-breakpoints="sm">{{ translate('TXN ID') }}</th>
                            <th>{{ translate('Receipt') }}</th>
                            <th>{{ translate('Date') }}</th>
                            <th class="text-right">{{ translate('Approval') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $package_payments as $key => $payment )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    @if ( $payment->package != null )
                                        {{ $payment->package->name }}
                                    @else
                                        {{ translate('Package Removed') }}
                                    @endif
                                </td>
                                <td>{{ $payment->package_type }}</td>
                                <td>
                                  @if ( $payment->user != null )
                                    {{ $payment->user->name }}
                                  @else
                                    {{translate('Not Found')}}
                                  @endif
                                </td>
                                <td>{{single_price($payment->amount)}}</td>
                                <td>
                                    <span class="badge badge-inline badge-success">
                                      {{ $payment->payment_method }}
                                    </span>
                                </td>
                                <td>{{ $payment->payment_details }}</td>
                                <td>
                                  @if ($payment->receipt != null)
                                      <a href="{{ custom_asset($payment->receipt) }}" target="_blank">{{translate('Open Reciept')}}</a>
                                  @endif
                                </td>
                                <td>{{$payment->created_at}}</td>
                                <td class="text-right">
                                    @if($payment->approval == 1)
                                        <span class="badge badge-inline badge-success">{{ translate('Approved')}}</span>
                                    @else
                                        <a href="javascript:void(0)" data-target="#offline_package_payment_approval_modal" data-href="{{route('offline_package_payment.approve', $payment->id)}}" class="btn btn-sm btn-primary confirm-alert">{{ translate('Approve')}}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{ $package_payments->appends(request()->input())->links() }}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    <!-- Offline Package Payment Approval modal -->
    <div class="modal fade" id="offline_package_payment_approval_modal">
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
