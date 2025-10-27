@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">USERS</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-success color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">ACTIVE</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-danger color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">INACTIVE</div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Users</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#new">
                    <i class="fa fa-plus"></i>
                    Add user
                </button>

                @include('components.error')

                <table class="table table-bordered table-hover table-sm tables">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#edit{{ $user->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                @if($user->status == "Active")
                                <form method="POST" action="{{ url('users/deactive/'.$user->id) }}"
                                    style="display: inline-block;">
                                    @csrf

                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                </form>
                                @else
                                <form method="POST" action="{{ url('users/active/'.$user->id) }}"
                                    style="display: inline-block;">
                                    @csrf

                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#password{{ $user->id }}">
                                    <i class="fa fa-key"></i>
                                </button>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->company->name }}</td>
                            <td>{{ $user->department->name }}</td>
                            <td></td>
                            <td>
                                @if($user->status == "Active")
                                <span class="badge badge-success">
                                    @elseif($user->status == "Inactive")
                                    <span class="badge badge-danger">
                                        @endif

                                        {{ $user->status }}
                                    </span>
                            </td>
                        </tr>

                        @include('users.edit')
                        @include('users.password')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('users.new')
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(".tables").DataTable({
            ordering: false,
            pageLength: 15,
            stateSave: true
        })

        $('.select2').select2()
    })
</script>
@endsection