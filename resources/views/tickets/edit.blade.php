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
                                    <option value="{{ $personnel->id }}" @if($ticket->assigned_to == $personnel->id) selected @endif>{{ $personnel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            Priority :
                            <select data-placeholder="Select priority" name="priority" class="form-control select2" style="width: 100%;">
                                <option value=""></option>
                                <option value="High" @if($ticket->priority == "High") selected @endif>High</option>
                                <option value="Medium" @if($ticket->priority == "Medium") selected @endif>Medium</option>
                                <option value="Low" @if($ticket->priority == "Low") selected @endif>Low</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            Category :
                            <select data-placeholder="Select category" name="category" class="form-control select2" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if($ticket->category_id == $category->id) selected @endif>{{ $category->name }}</option>
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