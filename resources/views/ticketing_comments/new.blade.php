<div class="modal" id="new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add new ticketing comment</h6>
            </div>
            <form method="POST" action="{{ url('ticketing_comments/store') }}">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Type :
                            <select data-placeholder="Select type" name="type" class="form-control select2" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($ticketing_types as $type)
                                    <option value="{{ $type->id }}" @if(old('type') == $type->id) selected @endif>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            Info :
                            <textarea name="info" class="form-control input-sm" cols="30" rows="10">{{ old('info') }}</textarea>
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