@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">TICKETS</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-success color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">OPEN</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-danger color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">CLOSE</div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Assign to me</h5>
            </div>
            <div class="card-body">
                @include('components.error')

                <table class="table table-bordered table-hover table-sm tables">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Ticket #</th>
                            <th>Date Created</th>
                            <th>Subject</th>
                            <th>Priority</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $key=>$ticket)
                            <tr>
                                <td>
                                    <a href="{{ url('tickets/details/'.$ticket->id) }}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit{{ $role->id }}">
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
                                    @endif --}}
                                </td>
                                <td>{{ str_pad($ticket->id, '7', 0, STR_PAD_LEFT) }}</td>
                                <td>{{ date('M d, Y', strtotime($ticket->created_at)) }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ $ticket->priority }}</td>
                                <td>
                                    @if($ticket->assigned_to)
                                        {{ $ticket->assignTo->name }}
                                    @else
                                        No IT assigned yet
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->status == "Open")
                                    <span class="badge badge-success">
                                    @elseif($ticket->status == "Closed")
                                    <span class="badge badge-danger">
                                    @endif

                                    {{ $ticket->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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