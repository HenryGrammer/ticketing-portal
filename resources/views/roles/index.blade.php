@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">ROLES</div>
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
                <h5>Roles</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#new">
                    <i class="fa fa-plus"></i>
                    Add role
                </button>

                @include('components.error')

                <table class="table table-bordered table-hover table-sm tables">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit{{ $role->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @if($role->status == "Active")
                                    <form method="POST" action="{{ url('companies/deactive/'.$role->id) }}" style="display: inline-block;">
                                        @csrf

                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ url('companies/active/'.$role->id) }}" style="display: inline-block;">
                                        @csrf

                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                <td>{{ $role->code }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if($role->status == "Active")
                                    <span class="badge badge-success">
                                    @elseif($role->status == "Inactive")
                                    <span class="badge badge-danger">
                                    @endif

                                    {{ $role->status }}
                                    </span>
                                </td>
                            </tr>

                            {{-- @include('companies.edit') --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('roles.new')
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(".tables").DataTable({
            ordering: false,
            pageLength: 15
        })
    })
</script>
@endsection