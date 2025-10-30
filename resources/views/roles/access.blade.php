@extends('layouts.header')

@section('content')
    @php
        $permissions = $role->access_module->pluck('permissions')->toArray();
    @endphp
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Access Module ( {{ $role->name }} )</h6>
        </div>
        <form method="post" action="{{ url('roles/store_access') }}">
            @csrf

            <input type="hidden" name="role_id" value="{{ $role->id }}">

            <div class="card-body">
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Create ticket" @if(in_array('Create ticket', $permissions)) checked @endif>
                        <span class="input-span"></span>Create ticket
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Edit ticket" @if(in_array('Edit ticket', $permissions)) checked @endif>
                        <span class="input-span"></span>Edit ticket
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="View ticket" @if(in_array('View ticket', $permissions)) checked @endif>
                        <span class="input-span"></span>View ticket
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Assign to me" @if(in_array('Assign to me', $permissions)) checked @endif>
                        <span class="input-span"></span>Assign to me
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="List of tickets" @if(in_array('List of tickets', $permissions)) checked @endif>
                        <span class="input-span"></span>List of tickets
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Reports" @if(in_array('Reports', $permissions)) checked @endif>
                        <span class="input-span"></span>Reports
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Users" @if(in_array('Users', $permissions)) checked @endif>
                        <span class="input-span"></span>Users
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Create user" @if(in_array('Create user', $permissions)) checked @endif>
                        <span class="input-span"></span>Create user
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Edit user" @if(in_array('Edit user', $permissions)) checked @endif>
                        <span class="input-span"></span>Edit user
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Change password" @if(in_array('Change password', $permissions)) checked @endif>
                        <span class="input-span"></span>Change password
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Companies" @if(in_array('Companies', $permissions)) checked @endif>
                        <span class="input-span"></span>Companies
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Create company" @if(in_array('Create company', $permissions)) checked @endif>
                        <span class="input-span"></span>Create company
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Edit company" @if(in_array('Edit company', $permissions)) checked @endif>
                        <span class="input-span"></span>Edit company
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Departments" @if(in_array('Departments', $permissions)) checked @endif>
                        <span class="input-span"></span>Departments
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Create department" @if(in_array('Create department', $permissions)) checked @endif>
                        <span class="input-span"></span>Create department
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Edit department" @if(in_array('Edit department', $permissions)) checked @endif>
                        <span class="input-span"></span>Edit department
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Roles" @if(in_array('Roles', $permissions)) checked @endif>
                        <span class="input-span"></span>Roles
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Create role" @if(in_array('Create role', $permissions)) checked @endif>
                        <span class="input-span"></span>Create role
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Edit role" @if(in_array('Edit role', $permissions)) checked @endif>
                        <span class="input-span"></span>Edit role
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="View role" @if(in_array('View role', $permissions)) checked @endif>
                        <span class="input-span"></span>View role
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Ticket comment" @if(in_array('Ticket comment', $permissions)) checked @endif>
                        <span class="input-span"></span>Ticket comment
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Create ticket comment" @if(in_array('Create ticket comment', $permissions)) checked @endif>
                        <span class="input-span"></span>Create ticket comment
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Edit ticket comment" @if(in_array('Edit ticket comment', $permissions)) checked @endif>
                        <span class="input-span"></span>Edit ticket comment
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Ticket type" @if(in_array('Ticket type', $permissions)) checked @endif>
                        <span class="input-span"></span>Ticket type
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Create ticket type" @if(in_array('Create ticket type', $permissions)) checked @endif>
                        <span class="input-span"></span>Create ticket type
                    </label>
                </div>
                <div>
                    <label class="ui-checkbox ui-checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="Edit ticket type" @if(in_array('Edit ticket type', $permissions)) checked @endif>
                        <span class="input-span"></span>Edit ticket type
                    </label>
                </div>
            </div>
            <div class="card-footer">
                <div>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection