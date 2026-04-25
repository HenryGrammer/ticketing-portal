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
                <h5>List of Tickets</h5>
            </div>
            <div class="card-body">
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
@include('tickets.edit')
@endsection

@section("js")
<script src="{{ asset("js/Helper.js") }}"></script>
<script>
    function itPersonnel() {
        initializeAjax("POST", "{{ config('app.url') }}/tickets/it-personnel", {}, {
            success: function(response) {
                var option = "<option></option>"
                if (response.length > 0) {
                    response.forEach(res => {
                        option += `<option value="${res.id}">${res.name}</option>`
                    })
                }

                $("[name='assigned_to']").html(option)
                $("[name='assigned_to']").select2({
                    allowClear: true
                })
            }
        })
    }

    function priority() {
        initializeAjax("POST", "{{ config('app.url') }}/tickets/priority", {}, {
            success: function(response) {
                var option = "<option></option>"
                if (response.length > 0) {
                    response.forEach((res, key) => {
                        option += `<option value="${key+1}">${res}</option>`
                    })
                }

                $("[name='priority']").html(option)
                $("[name='priority']").select2({
                    allowClear: true
                })
            }
        })
    }

    function category() {
        initializeAjax("POST", "{{ config('app.url') }}/tickets/category", {}, {
            success: function(response) {
                var option = "<option></option>"
                if (response.length > 0) {
                    response.forEach((res, key) => {
                        option += `<option value="${res.id}">${res.name}</option>`
                    })
                }

                $("[name='category']").html(option)
                $("[name='category']").select2({
                    allowClear: true
                })
            }
        })
    }

    $(document).ready(function() {
        itPersonnel()
        priority()
        category()

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
                                <a class="dropdown-item" href="javascript:void(0)" id="assignDropdown" data-id="${row.id}">Assign ticket</a>
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
                    if (row.status == "Cancelled" || row.status == "Closed") {
                        badgeClass = 'bg-danger'
                    }
                    else if(row.status == "Acknowledge") {
                        badgeClass = "bg-warning"
                    }

                    return `<span class="badge ${badgeClass}">${row.status}</span>`
                }
            },
        ];

        initializeDataTable("#ticketTable", "{{ config('app.url') }}/tickets/list/data", "POST", columns)

        $(document).on("click", "#viewDropdown", function(e) {
            e.preventDefault()

            var id = $(this).data("id")
            
            window.location.href = "{{ config('app.url') }}/tickets/details/"+id
        })

        $(document).on("click", "#assignDropdown", function() {
            var id = $(this).data("id")
            
            $("#assign").modal("show")
            $("[name='ticket_id']").val(id)
        })

        $("#assignForm").on("submit", function(e) {
            e.preventDefault()

            var formData = $(this).serializeArray()
            var id = $("[name='ticket_id']").val()
            initializeAjax("POST", "{{ config('app.url') }}/tickets/update/"+id, formData, {
                beforeSend: function() {
                    isDisableButton("assignBtn", true, "Updating...")
                },
                success: function(response) {
                    if (response.status == "success") {
                        reloadTable("ticketTable")
                        successMessage(response.message)
                        $("#assign").modal("hide")
                    }
                },
                complete: function() {
                    isDisableButton("assignBtn", false, "Update")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    displayError("assignForm", errors)
                }
            })
        })
    })
</script>
@endsection