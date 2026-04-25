@extends('layouts.header')
@section("css")
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; flex-direction:row; justify-content:space-between;">
                    <div class="d-flex justify-content-center align-items-center">
                        <h6 class="card-title">View ticket details - 
                        </h6>
                        <div class="badge-container ml-3">
                            @if($ticket->status == "Acknowledge")
                                <span class="badge bg-warning">{{$ticket->status}}</span>
                            @elseif($ticket->status == "Cancelled")
                                <span class="badge bg-danger">{{$ticket->status}}</span>
                            @elseif($ticket->status == "Closed")
                                <span class="badge bg-danger">{{$ticket->status}}</span>
                            @elseif($ticket->status == "Open")
                                <span class="badge bg-success">{{$ticket->status}}</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <form method="post" action="{{ url('tickets/acknowledgement/'.$ticket->id) }}" style="display: inline-block;">
                            @csrf
                            <input type="hidden" name="ticketing_type" value="Acknowledgement">
    
                            <button type="button" class="btn btn-info dropdown-toggle {{ $ticket->status == "Closed" || $ticket->status == "Cancelled" ? 'd-none' : 'd-block'}}" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v mr-2" aria-hidden="true"></i>
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" id="acknowledgeDropdown" data-id="{{ $ticket->id }}">Acknowledge</a>
                                <a class="dropdown-item" href="javascript:void(0)" id="closeDropdown" data-id="{{ $ticket->id }}">Closed</a>
                                <a class="dropdown-item" href="javascript:void(0)" id="cancelDropdown" data-id="{{ $ticket->id }}">Cancelled</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Ticket # :</dt>
                            <dd class="col-sm-9">#{{ str_pad($ticket->id, '7', 0, STR_PAD_LEFT) }}</dd>
                            <dt class="col-sm-3 text-right">Viber # :</dt>
                            <dd class="col-sm-9">{{ $ticket->viber_number }}</dd>
                            <dt class="col-sm-3 text-right">Department :</dt>
                            <dd class="col-sm-9">{{ $ticket->department->name }}</dd>
                            {{-- <dt class="col-sm-3 text-right">Status :</dt>
                            <dd class="col-sm-9">{{ $ticket->status }}</dd> --}}
                            <dt class="col-sm-3 text-right">Priority :</dt>
                            <dd class="col-sm-9">{{ $ticket->priority }}</dd>
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Ticket by :</dt>
                            <dd class="col-sm-9">{{ $ticket->createdBy->name }}</dd>
                            <dt class="col-sm-3 text-right">Assigned to :</dt>
                            <dd class="col-sm-9">
                                @if ($ticket->assignTo)
                                    {{ $ticket->assignTo->name }}
                                @else
                                    No IT assign yet
                                @endif
                            </dd>
                            <dt class="col-sm-3 text-right">Category :</dt>
                            <dd class="col-sm-9">
                                @if($ticket->category)
                                {{ $ticket->category->name }}
                                @else
                                No category yet
                                @endif
                            </dd>
                            <dt class="col-sm-3 text-right">Date Created :</dt>
                            <dd class="col-sm-9">{{ date('M d Y', strtotime($ticket->created_at)) }}</dd>
                            <dt class="col-sm-3 text-right">Proof :</dt>
                            <dd class="col-sm-9">
                                @if($ticket->proof)
                                    <a href="{{ url($ticket->proof) }}" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
                <hr>
                <h6>Ticket Thread</h6>
                <div class="ibox ibox-primary border border-primary">
                    <div class="ibox-head">{{ $ticket->subject }}</div>
                    <div class="ibox-body">
                        <p>{!! nl2br(e(strip_tags($ticket->task))) !!}</p>
                        @if($ticket->attachment)
                        <img src="{{ url($ticket->attachment) }}" style="width:min-content; height:400px;">
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Comments</div>
                            </div>
                            <div class="ibox-body">
                                <ul class="media-list media-list-divider m-0">
                                </ul>
                            </div>
                        </div>

                        <form method="POST" id="commentForm">
                            @csrf
                            
                            <input type="hidden" name="threadId">

                            <div class="row">
                                <div class="col-md-12">
                                    Comment :
                                    <textarea name="comment" class="form-control input-sm" placeholder="Write a comment..." cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success float-right mt-4" id="commentBtn">Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @include('tickets.close_ticket') --}}
@include('tickets.edit_comment')
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script src="{{ asset('js/Helper.js') }}"></script>
<script>
    function loadComments() {
        var ticketId = "{{ $ticket->id }}";
        
        initializeAjax("POST", "{{ config('app.url') }}/tickets/comment", {id: ticketId}, {
            success: function(response) {
                $(".media-list").html("")
                var list = ""
                response.forEach(res => {
                    list += `
                        <li class="media">
                            <a class="media-img" href="javascript:;">
                                <img class="img-circle" src="{{ asset('assets/img/admin-avatar.png') }}" width="40">
                            </a>
                            <div class="media-body">
                                <div class="media-heading">${res.user.name}<small class="float-right text-muted">${res.createdAt}</small></div>
                                <div class="font-13">${res.comment}</div>
                                <div style="display: flex; flex-direction:row; column-gap:5px; margin-top:20px;">
                                    <div>
                                        <small><a class="text-primary editComment" data-id="${res.id}">Edit</a></small>
                                    </div>
                                    <div>
                                        <small><a class="text-primary deleteComment" data-id="${res.id}">Delete</a></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `
                });
                
                $(".media-list").html(list)
            }
        })
    }

    function refreshStatus(color, name) {
        $(".badge-container").html("")
        var badge = `<span class='badge bg-${color}'>${name}</span>`
        $(".badge-container").html(badge)
    }

    $(document).ready(function() {
        loadComments()

        $("[name='comment']").summernote({
            height: 200,
            placeholder: "Write a comment"
        })

        $("#commentForm").on("submit", function(e) {
            e.preventDefault()

            var ticketId = "{{ $ticket->id }}";
            var formData = $(this).serializeArray()
            initializeAjax("POST", "{{ config('app.url') }}/tickets/store-comment/"+ticketId, formData, {
                beforeSend: function() {
                    isDisableButton("commentBtn", true, "Commenting...")
                },
                success: function(response) {
                    if (response.status == "success") {
                        successMessage(response.message)
                        loadComments()
                        $("#commentForm").trigger("reset")
                    }
                },
                complelete: function() {
                    isDisableButton("commentBtn", false, "Comment")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    errorMessage(errors.comment[0])
                    isDisableButton("commentBtn", false, "Comment")
                }
            })
        })

        $(document).on("click", ".deleteComment", function() {
            var id = $(this).data("id")

            bootbox.confirm({
                title:"Activate",
                message: 'Are you sure you want to delete this comment?',
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result) {
                        initializeAjax("POST", "{{ config('app.url') }}/tickets/delete-comment/"+id, {}, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    loadComments()
                                } else {
                                    errorMessage(response.message)
                                }
                            }
                        })
                    }
                }
            });
        })

        $(document).on("click", ".editComment", function() {
            var id = $(this).data("id")
            $("#edit").modal("show")

            initializeAjax("POST", "{{ config('app.url') }}/tickets/edit-comment/"+id, {}, {
                success: function(response) {
                    $("[name='editComment']").summernote("code", response.comment)
                    $("[name='comment_id']").val(response.id)
                }
            })
        })

        $("#editCommentForm").on("submit", function(e) {
            e.preventDefault()

            var id = $("[name='comment_id']").val()
            var formData = $(this).serializeArray()
            initializeAjax("POST", "{{ config('app.url') }}/tickets/update-comment/"+id, formData, {
                beforeSend: function() {
                    isDisableButton("updateBtn", true, "Commenting...")
                },
                success: function(response) {
                    if (response.status == "success") {
                        successMessage(response.message)
                        loadComments()
                        $("#editCommentForm").trigger("reset")
                    }
                },
                complete: function() {
                    isDisableButton("updateBtn", false, "Comment")
                    $("#edit").modal("hide")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    errorMessage(errors.comment[0])
                    isDisableButton("updateBtn", false, "Comment")
                }
            })
        })

        $("#acknowledgeDropdown").on("click", function() {
            var id = $(this).data("id")

            bootbox.confirm({
                title:"Activate",
                message: 'Are you sure you want to acknowledge this ticket?',
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result) {
                        var formData = {
                            ticketing_type: 1
                        }
                        initializeAjax("POST", "{{ config('app.url') }}/tickets/acknowledgement/"+id, formData, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    loadComments()
                                    refreshStatus("warning", "Acknowledge")
                                } else {
                                    errorMessage(response.message)
                                }
                            }
                        })
                    }
                }
            });
        })

        $("#cancelDropdown").on("click", function() {
            var id = $(this).data("id")

            bootbox.confirm({
                title:"Activate",
                message: 'Are you sure you want to cancel this ticket?',
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result) {
                        var formData = {
                            ticketing_type: 6
                        }
                        initializeAjax("POST", "{{ config('app.url') }}/tickets/cancelled/"+id, formData, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    loadComments()
                                    refreshStatus("danger", "Cancelled")
                                    $(".dropdown-toggle").removeClass('d-block').addClass("d-none")
                                } else {
                                    errorMessage(response.message)
                                }
                            }
                        })
                    }
                }
            });
        })

        $("#closeDropdown").on("click", function() {
            var id = $(this).data("id")

            bootbox.confirm({
                title:"Activate",
                message: 'Are you sure you want to close this ticket?',
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result) {
                        var formData = {
                            ticketing_type: 4
                        }
                        initializeAjax("POST", "{{ config('app.url') }}/tickets/close_ticket/"+id, formData, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    loadComments()
                                    refreshStatus("danger", "Closed")
                                    $(".dropdown-toggle").removeClass('d-block').addClass("d-none")
                                } else {
                                    errorMessage(response.message)
                                }
                            }
                        })
                    }
                }
            });
        })
    })
</script>
@endsection