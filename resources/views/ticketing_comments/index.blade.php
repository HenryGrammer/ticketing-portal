@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">TICKETS COMMENTS</div>
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
                <h5>Ticketing Comments</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#new">
                    <i class="fa fa-plus"></i>
                    Add ticketing comment
                </button>

                @include('components.error')

                <table class="table table-bordered table-hover table-sm tables">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Type</th>
                            <th>Information</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketing_comments as $key=>$comment)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit{{ $comment->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @if($comment->status == "Active")
                                    <form method="POST" action="{{ url('ticketing_comments/deactive/'.$comment->id) }}" style="display: inline-block;">
                                        @csrf

                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ url('ticketing_comments/active/'.$comment->id) }}" style="display: inline-block;">
                                        @csrf

                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                <td>{{ $comment->ticketing_type->name }}</td>
                                <td>{!! nl2br(e($comment->information)) !!}</td>
                                <td>
                                    @if($comment->status == "Active")
                                    <span class="badge badge-success">
                                    @elseif($comment->status == "Inactive")
                                    <span class="badge badge-danger">
                                    @endif

                                    {{ $comment->status }}
                                    </span>
                                </td>
                            </tr>

                            @include('ticketing_comments.edit')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('ticketing_comments.new')
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