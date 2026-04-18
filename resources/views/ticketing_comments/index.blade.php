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

                <table class="table table-bordered table-hover table-sm tables" id="ticketingCommentTable">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Type</th>
                            <th>Information</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('ticketing_comments.new')
@include('ticketing_comments.edit')
@endsection

@section('js')
<script src="{{ asset("js/Helper.js") }}"></script>
<script>
    function ticketingType() {
        initializeAjax("POST", "{{ config('app.url') }}/ticketing_comments/ticketing-types", {}, {
            success: function(response) {
                var option = "<option></option>"
                response.forEach(res => {
                    option += `<option value="${res.id}">${res.name}</option>`
                })

                $("[name='type']").html(option)
                $("[name='type']").select2({
                    allowClear: true
                })
            }
        })
    }

    $(document).ready(function() {
        ticketingType()

        var columns = [
            {
                data: "Action",
                render: function(data, type, row) {
                    return `
                        <div class="dropdown">
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v mr-2" aria-hidden="true"></i>
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" id="editDropdown" data-id="${row.id}">Edit</a>
                                ${
                                    row.status == "Active"
                                    ?
                                    `<a class="dropdown-item" href="javascript:void(0)" id="deactivateDropdown" data-id="${row.id}">Deactivate</a>`
                                    :
                                    `<a class="dropdown-item" href="javascript:void(0)" id="activateDropdown" data-id="${row.id}">Activate</a>`
                                }
                            </div>
                        </div>
                    `;
                }
            },
            {
                data: "type",
                render: function(data, type, row) {
                    return row.ticketing_type.name
                }
            },
            {data: "information"},
            {
                data: "status",
                render: function(data, type, row) {
                    let badgeClass = 'bg-success'
                    if (row.status == "Inactive") {
                        badgeClass = 'bg-danger'
                    }

                    return `<span class="badge ${badgeClass}">${row.status}</span>`
                }
            },
        ];

        initializeDataTable("#ticketingCommentTable", "{{ config('app.url') }}/ticketing_comments/list", "POST", columns)

        $("#addTicketingCommentForm").on("submit", function(e) {
            e.preventDefault()

            var formData = $(this).serializeArray()

            initializeAjax("POST", "{{ config('app.url') }}/ticketing_comments/store", formData, {
                beforeSend: function() {
                    isDisableButton("saveBtn", true, "Saving...")
                },
                success: function(response) {
                    if (response.status == "success") {
                        reloadTable("ticketingCommentTable")
                        $("#new").modal("hide")
                        successMessage(response.message)
                    }
                },
                complete: function() {
                    isDisableButton("saveBtn", false, "Save")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    displayError("addTicketingCommentForm", errors)
                }
            })
        })
        
        $(document).on("click", "#editDropdown", function(e) {
            e.preventDefault()

            var id = $(this).data("id")
            $("#edit").modal("show")
            initializeAjax("POST", "{{ config('app.url') }}/ticketing_comments/edit/"+id, {}, {
                success: function(response) {
                    $("[name='info']").text(response.information)
                    $("[name='type']").val(response.ticketing_type_id).trigger("change")
                    $("[name='id']").val(response.id)
                }
            })
        })

        $("#updateTicketingCommentForm").on("submit", function(e) {
            e.preventDefault()

            var formData = $(this).serializeArray()
            var id = $("[name='id']").val()
            initializeAjax("POST", "{{ config('app.url') }}/ticketing_comments/update/"+id, formData, {
                beforeSend: function() {
                    isDisableButton("updateBtn", true, "Updating...")
                },
                success: function(response) {
                    if (response.status == "success") {
                        reloadTable("ticketingCommentTable")
                        $("#edit").modal("hide")
                        successMessage("Successfully Saved")
                    }
                },
                complete: function() {
                    isDisableButton("updateBtn", false, "Update")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    displayError("updateTicketingCommentForm", errors)
                }
            })
        })

        $(document).on("click", "#deactivateDropdown", function() {
            var id = $(this).data("id")
            
            bootbox.confirm({
                title:"Deactivate",
                message: 'Are you sure you want to deactivate this role?',
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
                        initializeAjax("POST", "{{ config('app.url') }}/ticketing_comments/deactive/"+id, {}, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    reloadTable("ticketingCommentTable")
                                } else {
                                    errorMessage(response.message)
                                }
                            }
                        })
                    }
                }
            });
        })

        $(document).on("click", "#activateDropdown", function() {
            var id = $(this).data("id")
            
            bootbox.confirm({
                title:"Activate",
                message: 'Are you sure you want to activate this role?',
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
                        initializeAjax("POST", "{{ config('app.url') }}/ticketing_comments/active/"+id, {}, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    reloadTable("ticketingCommentTable")
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