@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">TICKETS TYPES</div>
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
                <h5>Ticketing Types</h5>
            </div>
            <div class="card-body">
                @can('create', App\Role::class)
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#new">
                    <i class="fa fa-plus"></i>
                    Add ticketing type
                </button>
                @endcan

                @include('components.error')

                <table class="table table-bordered table-hover table-sm tables">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketing_types as $key=>$type)
                            <tr>
                                <td>
                                    @can('update', App\Role::class)
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit{{ $type->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        @if($type->status == "Active")
                                        <form method="POST" action="{{ url('ticketing_types/deactive/'.$type->id) }}" style="display: inline-block;">
                                            @csrf

                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form method="POST" action="{{ url('ticketing_types/active/'.$type->id) }}" style="display: inline-block;">
                                            @csrf

                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                    @endcan
                                </td>
                                <td>{{ $type->name }}</td>
                                <td>
                                    @if($type->status == "Active")
                                    <span class="badge badge-success">
                                    @elseif($type->status == "Inactive")
                                    <span class="badge badge-danger">
                                    @endif

                                    {{ $type->status }}
                                    </span>
                                </td>
                            </tr>

                            @include('ticketing_types.edit')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('ticketing_types.new')
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(".tables").DataTable({
            ordering: false,
            pageLength: 15
        })

        $(".select2").select2()

        // $("#summernote").summernote({
        //     height: 150, // Set desired height
        //     dialogsInBody: true, // Crucial for modal integration
        //     callbacks: {
        //         onImageUpload: function(files) {
        //             uploadImage(files[0])
        //         }
        //     }
        // })

        // function uploadImage(file) {
        //     var data = new FormData()
        //     data.append("file", file)
        //     data.append("_token", '{{ csrf_token() }}')

        //     $.ajax({
        //         url: "{{ url('tickets/upload_image') }}",
        //         type:"POST",
        //         cache:false,
        //         contentType: false,
        //         processData: false,
        //         data: data,
        //         success:function(url) {
        //             $("#summernote").summernote('insertImage',url)
        //         }
        //     })
        // }
    })
</script>
@endsection