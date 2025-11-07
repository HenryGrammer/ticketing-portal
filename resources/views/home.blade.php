@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Count of tickets <span class="label label-primary">as of ({{ date('Y') }})</span></div>
            </div>
            <div class="ibox-body">
                <div id="morris_bar_chart" style="height:280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Category <span class="label label-primary">as of ({{ date('Y') }})</span></div>
            </div>
            <div class="ibox-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categoryArray as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-body">
                <form method="get" action="">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="month" name="month" value="{{ $month_data }}" class="form-control input-sm">
                        </div>
                        @if(auth()->user()->role->name == "Administrator")
                        <div class="col-md-4">
                            <select data-placeholder="Select personnel" name="personnel" class="select2 form-control">
                                <option value=""></option>
                                @foreach ($it_personnels as $personnel)
                                    <option value="{{ $personnel->id }}" @if($personnel_data == $personnel->id) selected @endif>{{ $personnel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Tickets <span class="label label-primary">as of ({{ date('Y') }})</span></div>
            </div>
            <div class="ibox-body">
                <div class="table-responsive">
                    <table class="table table-bordered tables">
                        <thead>
                            <tr>
                                <th>Ticket Number</th>
                                <th>Requestor</th>
                                <th>Subject</th>
                                <th>Priority Level</th>
                                <th>Staff Assigned</th>
                                <th>Date Created</th>
                                <th>Target</th>
                                <th>Closed Date</th>
                                <th>Ticket Duration</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets_per_personnel as $ticket)
                            <tr>
                                <td>{{ str_pad($ticket->id, '7', 0, STR_PAD_LEFT) }}</td>
                                <td>{{ $ticket->createdBy->name }}</td>
                                <td>{!! nl2br(e($ticket->task)) !!}</td>
                                <td>{{ $ticket->priority }}</td>
                                <td>{{ $ticket->assignTo->name }}</td>
                                <td>{{ date('M d Y', strtotime($ticket->created_at)) }}</td>
                                <td>0000-00-00</td>
                                <td>0000-00-00</td>
                                <td>0 day</td>
                                <td></td>
                                <td>{{ $ticket->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var months = {!! json_encode(collect($months)->pluck('month')->toArray()) !!}
        var ticketCounts = {!! json_encode(collect($months)->toArray()) !!}
        
        Morris.Bar({
            element: 'morris_bar_chart',
            data: ticketCounts,
            xkey: 'month',
            ykeys: ['tickets'],
            labels: ['Count'],
            hideHover: 'auto',
            resize: true,
            barColors: ['#2ecc71'],
        });

        $(".tables").DataTable({
            ordering: false,
            pageLength: 15,
            stateSave: true
        })

        $('.select2').select2()
    })
</script>
@endsection