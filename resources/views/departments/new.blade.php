<div class="modal" id="new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add new department</h6>
            </div>
            <form method="POST" action="{{ url('departments/store') }}">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Company :
                            <select data-placeholder="Select company" name="company" class="select2 form-control" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" @if(old('company') == $company->id) selected @endif>{{ $company->code.' '.$company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            Users :
                            <select data-placeholder="Select users" name="user" class="select2 form-control" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if(old('user') == $user->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            Code :
                            <input type="text" name="code" class="form-control input-sm" value="{{ old('code') }}">
                        </div>
                        <div class="col-md-12">
                            Name :
                            <input type="text" name="name" class="form-control input-sm" value="{{ old('name') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>