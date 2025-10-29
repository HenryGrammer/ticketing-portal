<div class="modal" id="edit{{ $type->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit ticketing type</h6>
            </div>
            <form method="POST" action="{{ url('ticketing_types/update/'.$type->id) }}">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Name :
                            <input type="text" name="name" class="form-control" value="{{ $type->name }}">
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