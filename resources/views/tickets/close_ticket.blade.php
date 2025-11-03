<div class="modal" id="closeTicket{{ $ticket->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Close ticket</h6>
            </div>
            <form method="POST" action="{{ url('tickets/close_ticket/'.$ticket->id) }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="ticketing_type" value="Closing Ticket">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Attach a proof :
                            <input type="file" name="proof" class="form-control input-sm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Close ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>