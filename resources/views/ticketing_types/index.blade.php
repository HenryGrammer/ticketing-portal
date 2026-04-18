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
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#new">
                    <i class="fa fa-plus"></i>
                    Add ticketing type
                </button>

                <table class="table table-bordered table-hover table-sm" id="ticketingTypeTable">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
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

@include('ticketing_types.new')
@include('ticketing_types.edit')
@endsection

@section('js')
<script src="{{ asset("js/Helper.js") }}"></script>
<script>
    $(document).ready(function() {
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
            {data: "name"},
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

        initializeDataTable("#ticketingTypeTable", "{{ config('app.url') }}/ticketing_types/list", "POST", columns)

        $("#addTicketingTypeForm").on("submit", function(e) {
            e.preventDefault()

            var formData = $(this).serializeArray()

            initializeAjax("POST", "{{ config('app.url') }}/ticketing_types/store", formData, {
                beforeSend: function() {
                    isDisableButton("saveBtn", true, "Saving...")
                },
                success: function(response) {
                    if (response.status == "success") {
                        reloadTable("ticketingTypeTable")
                        $("#new").modal("hide")
                    }
                },
                complete: function() {
                    isDisableButton("saveBtn", false, "Save")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    displayError("addTicketingTypeForm", errors)
                }
            })
        })
        
        $(document).on("click", "#editDropdown", function(e) {
            e.preventDefault()

            var id = $(this).data("id")
            $("#edit").modal("show")
            initializeAjax("POST", "{{ config('app.url') }}/ticketing_types/edit/"+id, {}, {
                success: function(response) {
                    $("[name='name']").val(response.name)
                    $("[name='id']").val(response.id)
                }
            })
        })

        $("#updateTicketingTypeForm").on("submit", function(e) {
            e.preventDefault()

            var formData = $(this).serializeArray()
            var id = $("[name='id']").val()
            initializeAjax("POST", "{{ config('app.url') }}/ticketing_types/update/"+id, formData, {
                beforeSend: function() {
                    isDisableButton("updateBtn", true, "Updating...")
                },
                success: function(response) {
                    if (response.status == "success") {
                        reloadTable("ticketingTypeTable")
                        $("#edit").modal("hide")
                    }
                },
                complete: function() {
                    isDisableButton("updateBtn", false, "Update")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    displayError("updateTicketingTypeForm", errors)
                }
            })
        })

        $(document).on("click", "#deactivateDropdown", function() {
            var id = $(this).data("id")
            
            bootbox.confirm({
                title:"Deactivate",
                message: 'Are you sure you want to deactivate this company?',
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
                        initializeAjax("POST", "{{ config('app.url') }}/ticketing_types/deactive/"+id, {}, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    reloadTable("ticketingTypeTable")
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
                message: 'Are you sure you want to activate this company?',
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
                        initializeAjax("POST", "{{ config('app.url') }}/ticketing_types/active/"+id, {}, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    reloadTable("ticketingTypeTable")
                                } else {
                                    errorMessage(response.message)
                                }
                            },
                            error: function(xhr) {
                                errorMessage("Something went wrong")
                            }
                        })
                    }
                }
            });
        })
    })
</script>
@endsection