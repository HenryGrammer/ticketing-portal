<div class="modal" id="new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add new ticketing type</h6>
            </div>
            <form method="POST" action="{{ url('ticketing_types/store') }}">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Name :
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
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