@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ $language->name }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('languages.key_value_store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $language->id }}">
                        <div class="">
                            <table class="aiz-table mb-0" data-paging="true" data-paging-size="50">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{translate('Key')}}</th>
                                        <th>{{translate('Value')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach (openJSONFile('en') as $key => $value)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $key }}</td>
                                        <td>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control" style="width:100%" name="key[{{ $key }}]" @isset(openJSONFile($language->code)[$key])
                                                    value="{{ openJSONFile($language->code)[$key] }}"
                                                @endisset>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save This')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
