<div class="modal" id="edit{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit user</h6>
            </div>
            <form method="POST" action="{{ url('users/update/'.$user->id) }}">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Company :
                            <select data-placeholder="Select company" name="company" class="select2 form-control"
                                style="width: 100%;">
                                <option value=""></option>
                                @foreach ($companies as $company)
                                <option value="{{ $company->id }}" @if($user->company_id==$company->id) selected @endif>{{
                                    $company->code.' '.$company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            Departments :
                            <select data-placeholder="Select departments" name="department" class="select2 form-control"
                                style="width: 100%;">
                                <option value=""></option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @if($user->department_id==$department->id) selected
                                    @endif>{{ $department->code .' - '.
                                    $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            Name :
                            <input type="text" name="name" class="form-control input-sm" value="{{ $user->name }}">
                        </div>
                        <div class="col-md-12">
                            Email :
                            <input type="email" name="email" class="form-control input-sm" value="{{ $user->email }}">
                        </div>
                        <div class="col-md-12">
                            Roles :
                            <select data-placeholder="Select roles" name="role" class="select2 form-control" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @if($user->role_id==$role->id) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>