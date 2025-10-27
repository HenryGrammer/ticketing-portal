<div class="modal" id="password{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Change password</h6>
            </div>
            <form method="POST" action="{{ url('users/password/'.$user->id) }}">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            New password :
                            <input type="password" name="password" class="form-control input-sm">
                        </div>
                        <div class="col-md-12">
                            Confirm password :
                            <input type="password" name="password_confirmation" class="form-control input-sm">
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