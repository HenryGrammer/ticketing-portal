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
                <h5>Tickets</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#new">
                    <i class="fa fa-plus"></i>
                    Add ticket
                </button>

                @include('components.error')

                <table class="table table-bordered table-hover table-sm" id="ticketTable">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('tickets.new')
@endsection

@section('js')
<script src="{{ asset("js/Helper.js") }}"></script>
<script>
    // function company() {
    //     initializeAjax("POST", "{{ config('app.url') }}/departments/company-list", {}, {
    //         success: function(response) {
    //             var option = "<option></option>"
    //             if (response.length > 0) {
    //                 response.forEach(res => {
    //                     option += `<option value="${res.id}">${res.code+' - '+res.name}</option>`
    //                 })
    //             }

    //             $("[name='company']").html(option)
    //             $("[name='company']").select2({
    //                 allowClear: true
    //             })
    //         }
    //     })
    // }
    
    // function user() {
    //     initializeAjax("POST", "{{ config('app.url') }}/departments/user-list", {}, {
    //         success: function(response) {
    //             var option = "<option></option>"
    //             if (response.length > 0) {
    //                 response.forEach(res => {
    //                     option += `<option value="${res.id}">${res.name}</option>`
    //                 })
    //             }

    //             $("[name='user']").html(option)
    //             $("[name='user']").select2({
    //                 allowClear: true
    //             })
    //         }
    //     })
    // }

    $(document).ready(function() {
        // company()
        // user()

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
                                <a class="dropdown-item" href="javascript:void(0)" id="viewDropdown" data-id="${row.id}">View</a>
                            </div>
                        </div>
                    `;
                }
            },
            {data: "ticket_id"},
            {data: "date_created"},
            {data: "subject"},
            {data: "priority"},
            {
                data: "assign_to", 
                render: function(data, type, row) {
                    if (row.assign_to) {
                        return row.assign_to.name
                    }
                    else {
                        return ''
                    }
                }
            },
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

        initializeDataTable("#ticketTable", "{{ config('app.url') }}/tickets/data", "POST", columns)

        $("#addTicketForm").on("submit", function(e) {
            e.preventDefault()

            var formData = new FormData($(this)[0])

            initializeAjax("POST", "{{ config('app.url') }}/tickets/store", formData, {
                contentType: false,
                processData: false,
                beforeSend: function() {
                    isDisableButton("saveBtn", true, "Saving...")
                },
                success: function(response) {
                    if (response.status == "success") {
                        reloadTable("ticketTable")
                        successMessage(response.message)
                        $("#new").modal("hide")
                    }
                },
                complete: function() {
                    isDisableButton("saveBtn", false, "Save")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    displayError("addTicketForm", errors)
                }
            })
        })
        
        $(document).on("click", "#viewDropdown", function(e) {
            e.preventDefault()

            var id = $(this).data("id")
            
            window.location.href = "{{ config('app.url') }}/tickets/details/"+id
        })

        // $(document).on("click", "#editDropdown", function(e) {
        //     e.preventDefault()

        //     var id = $(this).data("id")
        //     $("#edit").modal("show")
        //     initializeAjax("POST", "{{ config('app.url') }}/departments/edit/"+id, {}, {
        //         success: function(response) {
        //             $("[name='code']").val(response.code)
        //             $("[name='company']").val(response.company_id).trigger("change")
        //             $("[name='user']").val(response.user_id).trigger("change")
        //             $("[name='name']").val(response.name)
        //             $("[name='id']").val(response.id)
        //         }
        //     })
        // })

        // $("#updateDepartmentForm").on("submit", function(e) {
        //     e.preventDefault()

        //     var formData = $(this).serializeArray()
        //     var id = $("[name='id']").val()
        //     initializeAjax("POST", "{{ config('app.url') }}/departments/update/"+id, formData, {
        //         beforeSend: function() {
        //             isDisableButton("updateBtn", true, "Updating...")
        //         },
        //         success: function(response) {
        //             if (response.status == "success") {
        //                 reloadTable("departmentTable")
        //                 $("#edit").modal("hide")
        //             }
        //         },
        //         complete: function() {
        //             isDisableButton("updateBtn", false, "Update")
        //         },
        //         error: function(xhr) {
        //             var errors = xhr.responseJSON.errors
        //             displayError("updateDepartmentForm", errors)
        //         }
        //     })
        // })

        // $(document).on("click", "#deactivateDropdown", function() {
        //     var id = $(this).data("id")
            
        //     bootbox.confirm({
        //         title:"Deactivate",
        //         message: 'Are you sure you want to deactivate this department?',
        //         buttons: {
        //             confirm: {
        //                 label: 'Yes',
        //                 className: 'btn-success'
        //             },
        //             cancel: {
        //                 label: 'No',
        //                 className: 'btn-danger'
        //             }
        //         },
        //         callback: function (result) {
        //             if (result) {
        //                 initializeAjax("POST", "{{ config('app.url') }}/departments/deactive/"+id, {}, {
        //                     success: function(response) {
        //                         if(response.status == "success") {
        //                             successMessage(response.message)
        //                             reloadTable("departmentTable")
        //                         } else {
        //                             errorMessage(response.message)
        //                         }
        //                     }
        //                 })
        //             }
        //         }
        //     });
        // })

        // $(document).on("click", "#activateDropdown", function() {
        //     var id = $(this).data("id")
            
        //     bootbox.confirm({
        //         title:"Activate",
        //         message: 'Are you sure you want to activate this company?',
        //         buttons: {
        //             confirm: {
        //                 label: 'Yes',
        //                 className: 'btn-success'
        //             },
        //             cancel: {
        //                 label: 'No',
        //                 className: 'btn-danger'
        //             }
        //         },
        //         callback: function (result) {
        //             if (result) {
        //                 initializeAjax("POST", "{{ config('app.url') }}/departments/active/"+id, {}, {
        //                     success: function(response) {
        //                         if(response.status == "success") {
        //                             successMessage(response.message)
        //                             reloadTable("departmentTable")
        //                         } else {
        //                             errorMessage(response.message)
        //                         }
        //                     },
        //                     error: function(xhr) {
        //                         errorMessage("Something went wrong")
                                
        //                     }
        //                 })
        //             }
        //         }
        //     });
        // })
    })
</script>
@endsection  