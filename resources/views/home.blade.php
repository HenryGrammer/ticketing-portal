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
    @if(auth()->user()->role->name != "User")
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
                        @if(auth()->user()->role->name == "Administrator" || auth()->user()->role->name == "IT Head")
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
                                <th>Date Assign</th>
                                <th>Target</th>
                                <th>Closed Date</th>
                                <th>Ticket Duration</th>
                                <th>%</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $due = 0;
                                $avg_percent_total=0;
                                $percent_count=0;
                                $open=0;
                                $delayed=0;
                            @endphp
                            @foreach ($tickets_per_personnel as $ticket)
                            <tr>
                                <td>{{ str_pad($ticket->id, '7', 0, STR_PAD_LEFT) }}</td>
                                <td>{{ $ticket->createdBy->name }}</td>
                                <td>{!! nl2br(e($ticket->task)) !!}</td>
                                <td>{{ $ticket->priority }}</td>
                                <td>{{ $ticket->assignTo->name }}</td>
                                <td>{{ date('M d Y', strtotime($ticket->created_at)) }}</td>
                                <td>
                                    @if($ticket->date_assign)
                                        {{ date('M d Y', strtotime($ticket->date_assign)) }}
                                    @endif
                                </td>
                                @php
                                    $priority = $ticket->priority;
                                    if ($priority == "Low") {
                                        $per =5;
                                        $due_date = date('Y-m-d h:m', strtotime('+5 weekdays',strtotime($ticket->date_assign)));
                                    } elseif ($priority == "Medium") {
                                        $due_date = date('Y-m-d h:m', strtotime('+3 weekdays',strtotime($ticket->date_assign)));
                                        $per =3;
                                    } elseif ($priority == "High") {
                                        $due_date = date('Y-m-d h:m', strtotime('+1 day',strtotime($ticket->date_assign)));
                                        $per =1;
                                    } elseif ($priority == "Critical") {
                                        $due_date = date('Y-m-d h:m', strtotime('+4 hours',strtotime($ticket->date_assign)));
                                        $per =.17;
                                    }

                                    if($ticket->date_closed != null)
                                    {
                                        $datetime = strtotime($due_date)-strtotime($ticket->date_closed);
                                        $datediff = strtotime($ticket->date_closed)-strtotime($ticket->date_assign);
                                    }
                                    else {
                                        $datetime = strtotime($due_date)-strtotime(date('Y-m-d H:i:s'));
                                        $datediff = strtotime(date('Y-m-d H:i:s'))-strtotime($ticket->date_assign);
                                    }
                                @endphp
                                <td>{{ date('M d Y', strtotime($due_date)) }}</td>
                                <td>
                                    @if($ticket->date_closed)
                                        {{ date('M d Y', strtotime($ticket->date_closed)) }}
                                    @endif
                                </td>
                                <td>{{number_format($datediff/60/60/24,2)}} Days</td>
                                <td>
                                    @php
                                        $percent = (($datediff/60/60/24)/$per)*100;
                                        $avg_percent_total = $avg_percent_total + $percent;
                                        $percent_count++;
                                    @endphp
                                    {{number_format($percent,2)}} %
                                </td>
                                <td>
                                    @if($datetime>=0)
                                        Not Delayed
                                    @else
                                    @php
                                        $delayed++;
                                    @endphp
                                        Delayed
                                    @endif
                                </td>
                                <td>{{ $ticket->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
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