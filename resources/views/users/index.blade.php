@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="ibox bg-info color-white widget-stat">
            <div class="ibox-body">
                <h2 class="m-b-5 font-strong">0</h2>
                <div class="m-b-5">USERS</div>
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
                <h5>Users</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" id="addBtn" data-toggle="modal" data-target="#new">
                    <i class="fa fa-plus"></i>
                    Add user
                </button>

                <table class="table table-bordered table-hover table-sm" id="userTable">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Role</th>
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

@include('users.new')
@include('users.edit')
{{-- @include('users.password') --}}

@endsection

@section('js')
<script src="{{ asset("js/Helper.js") }}"></script>
<script>
    function companies() {
        initializeAjax("POST", "{{ config('app.url') }}/users/get-company", {}, {
            success: function(response) {
                var option = "<option></option>"
                response.forEach(res => {
                    option += `<option value="${res.id}">${res.name}</option>`
                })
                
                $("[name='company']").html(option)
                $("[name='company']").select2({
                    allowClear: true,
                })
            }
        })
    }

    function department() {
        initializeAjax("POST", "{{ config('app.url') }}/users/get-department", {}, {
            success: function(response) {
                var option = "<option></option>"
                response.forEach(res => {
                    option += `<option value="${res.id}">${res.name}</option>`
                })
                
                $("[name='department']").html(option)
                $("[name='department']").select2({
                    allowClear: true,
                })
            }
        })
    }

    function role() {
        initializeAjax("POST", "{{ config('app.url') }}/users/get-role", {}, {
            success: function(response) {
                var option = "<option></option>"
                response.forEach(res => {
                    option += `<option value="${res.id}">${res.name}</option>`
                })
                
                $("[name='role']").html(option)
                $("[name='role']").select2({
                    allowClear: true,
                })
            }
        })
    }
    
    $(document).ready(function() {
        companies()
        department()
        role()

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
            {data: "email"},
            {data: "company.Company"},
            {data: "department.Department"},
            {data: "role.Role"},
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

        initializeDataTable("#userTable", "{{ config('app.url') }}/users/list", "POST", columns)

        $("#addUserForm").on("submit", function(e) {
            e.preventDefault()

            var formData = $(this).serializeArray();

            initializeAjax("POST", "{{ config('app.url') }}/users/store", formData, {
                beforeSend: function() {
                    $("#saveBtn").prop("disabled", true).text("Saving...")
                },
                success: function(response) {
                    if(response.status == "success") {
                        successMessage(response.message)
                        $("#addUserForm").trigger("reset")
                    } else {
                        errorMessage(response.message)
                    }
                },
                complete: function() {
                    $("#saveBtn").prop("disabled", false).text("Save")
                    $("#new").modal("hide")
                    reloadTable("userTable")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    displayError("addUserForm", errors)
                }
            })
        })

        $(document).on("click", "#editDropdown", function() {
            $("#edit").modal("show")

            var id = $(this).data("id")
            initializeAjax("POST", `{{ config('app.url') }}/users/edit/${id}`, {}, {
                success: function(response) {
                    $("[name='company']").val(response.company_id).trigger("change")
                    $("[name='department']").val(response.department_id).trigger("change")
                    $("[name='name']").val(response.name)
                    $("[name='email']").val(response.email)
                    $("[name='id']").val(response.id)
                    $("[name='role']").val(response.role_id).trigger("change")
                }
            })
        })

        $("#updateUserForm").on("submit", function(e) {
            e.preventDefault()

            var formData = $(this).serializeArray();
            var id = $("[name='id']").val()
            initializeAjax("POST", "{{ config('app.url') }}/users/update/"+id, formData, {
                beforeSend: function() {
                    $("#updateBtn").prop("disabled", true).text("Updating...")
                },
                success: function(response) {
                    if(response.status == "success") {
                        successMessage(response.message)
                        $("#updateUserForm").trigger("reset")
                    } else {
                        errorMessage(response.message)
                    }
                },
                complete: function() {
                    $("#updateBtn").prop("disabled", false).text("Update")
                    $("#edit").modal("hide")
                    reloadTable("userTable")
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors
                    displayError("updateUserForm", errors)
                }
            })
        })

        $(document).on("click", "#deactivateDropdown", function() {
            var id = $(this).data("id")
            
            bootbox.confirm({
                title:"Deactivate",
                message: 'Are you sure you want to deactivate this user?',
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
                        initializeAjax("POST", "{{ config('app.url') }}/users/deactive/"+id, {}, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    reloadTable("userTable")
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
                message: 'Are you sure you want to activate this user?',
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
                        initializeAjax("POST", "{{ config('app.url') }}/users/active/"+id, {}, {
                            success: function(response) {
                                if(response.status == "success") {
                                    successMessage(response.message)
                                    reloadTable("userTable")
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