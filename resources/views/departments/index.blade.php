@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">DEPARTMENTS</div>
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
                <h5>Departments</h5>
            </div>
            <div class="card-body">
                @can('create', App\Department::class)
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#new">
                    <i class="fa fa-plus"></i>
                    Add department
                </button>
                @endcan

                @include('components.error')

                <table class="table table-bordered table-hover table-sm tables">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Company</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Department Head</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>
                                    @can('edit', App\Department::class)
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit{{ $department->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        @if($department->status == "Active")
                                        <form method="POST" action="{{ url('departments/deactive/'.$department->id) }}" style="display: inline-block;">
                                            @csrf

                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form method="POST" action="{{ url('departments/active/'.$department->id) }}" style="display: inline-block;">
                                            @csrf

                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                    @endcan
                                </td>
                                <td>{{ optional($department->company)->name }}</td>
                                <td>{{ $department->code }}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->user->name }}</td>
                                <td>
                                    @if($department->status == "Active")
                                    <span class="badge badge-success">
                                    @elseif($department->status == "Inactive")
                                    <span class="badge badge-danger">
                                    @endif

                                    {{ $department->status }}
                                    </span>
                                </td>
                            </tr>

                            @include('departments.edit')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('departments.new')
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(".tables").DataTable({
            ordering: false,
            pageLength: 15
        })

        $(".select2").select2({
            allowClear: true
        });
    })
</script>
@endsection