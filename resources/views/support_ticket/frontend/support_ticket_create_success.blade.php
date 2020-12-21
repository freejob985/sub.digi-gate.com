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
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="card px-5 py-7 text-center">
                                <h3 class="h5">{{ translate('Your ticket has been submited successfully.') }}</h3>
                                <p class="mb-0">{{ translate('Ticket id:') }} <span class="font-weight-bold h3 text-primary">{{$submit_id}}</span></p>
                                <a href="{{ route('support-tickets.user_index') }}" class="btn btn-soft-primary mt-3">{{ translate('View all tickets') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
