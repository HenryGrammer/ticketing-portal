<div class="modal" id="edit{{ $ticket->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Assigned ticket</h6>
            </div>
            <form method="POST" action="{{ url('tickets/update/'.$ticket->id) }}">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Assigned :
                            <select data-placeholder="Assigned personnel" name="assigned_to" class="form-control select2" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($it_personnels as $personnel)
                                    <option value="{{ $personnel->id }}">{{ $personnel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            Priority :
                            <select data-placeholder="Select priority" name="priority" class="form-control select2" style="width: 100%;">
                                <option value=""></option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            Category :
                            <select data-placeholder="Select category" name="category" class="form-control select2" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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