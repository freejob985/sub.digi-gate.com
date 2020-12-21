@extends('admin.default.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{translate('All Roles')}}</h1>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th data-breakpoints="">#</th>
                                <th data-breakpoints="">{{ translate('Name') }}</th>
                                <th data-breakpoints="" class="text-right">{{ translate('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $key => $role)
                            <tr>
                                <td>{{ ($key+1) + ($roles->currentPage() - 1)*$roles->perPage() }}</td>
                                <td>{{$role->name}}</td>
                                <td class="text-right">
                                    @if ($role->id == "1" || $role->id == "2" || $role->id == "3")
                                        <span class="badge badge-inline fw-400 badge-warning">{{translate('This is not editable or deletable')}}</span>
                                    @else
                                        <a href="{{ route('roles.edit', encrypt($role->id)) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm btn icon" title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-href="{{route('roles.destroy', $role->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Create new Role')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" id="name" name="name" class="form-control" required placeholder="Eg. Support Agent">
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Add New Role')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div>
    </div>
    <div class="row">
        {{ $roles->links() }}
    </div>
@endsection
@section('modal')
    @include('admin.default.partials.delete_modal')
@endsection
