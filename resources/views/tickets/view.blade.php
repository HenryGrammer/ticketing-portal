@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; flex-direction:row; justify-content:space-between;">
                    <h6 class="card-title">View ticket details</h6>

                    <form method="post" action="{{ url('tickets/acknowledgement/'.$ticket->id) }}">
                        @csrf

                        <input type="hidden" name="ticketing_type" value="Acknowledgement">

                        <button type="submit" class="btn btn-success">
                            Acknowledge
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Ticket # :</dt>
                            <dd class="col-sm-9">#{{ str_pad($ticket->id, '7', 0, STR_PAD_LEFT) }}</dd>
                            <dt class="col-sm-3 text-right">Viber # :</dt>
                            <dd class="col-sm-9">{{ $ticket->viber_number }}</dd>
                            <dt class="col-sm-3 text-right">Department :</dt>
                            <dd class="col-sm-9">{{ $ticket->department->name }}</dd>
                            <dt class="col-sm-3 text-right">Status :</dt>
                            <dd class="col-sm-9">{{ $ticket->status }}</dd>
                            <dt class="col-sm-3 text-right">Priority :</dt>
                            <dd class="col-sm-9">{{ $ticket->priority }}</dd>
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <dl class="row">
                            <dt class="col-sm-3 text-right">Ticket by :</dt>
                            <dd class="col-sm-9">{{ $ticket->createdBy->name }}</dd>
                            <dt class="col-sm-3 text-right">Assigned to :</dt>
                            <dd class="col-sm-9">
                                @if ($ticket->assignTo)
                                    {{ $ticket->assignTo->name }}
                                @else
                                    No IT assign yet
                                @endif
                            </dd>
                            <dt class="col-sm-3 text-right">Category :</dt>
                            <dd class="col-sm-9">
                                @if($ticket->category)
                                {{ $ticket->category->name }}
                                @else
                                No category yet
                                @endif
                            </dd>
                            <dt class="col-sm-3 text-right">Date Created :</dt>
                            <dd class="col-sm-9">{{ date('M d Y', strtotime($ticket->created_at)) }}</dd>
                        </dl>
                    </div>
                </div>
                <hr>
                <h6>Ticket Thread</h6>
                <div class="ibox ibox-primary border border-primary">
                    <div class="ibox-head">{{ $ticket->subject }}</div>
                    <div class="ibox-body">
                        {!! nl2br(e(strip_tags($ticket->task))) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Comments</div>
                            </div>
                            <div class="ibox-body">
                                <ul class="media-list media-list-divider m-0">
                                    @if (count($ticket->ticketing_thread) > 0)
                                        @foreach ($ticket->ticketing_thread as $thread)
                                        <li class="media">
                                            <a class="media-img" href="javascript:;">
                                                <img class="img-circle" src="{{ asset('assets/img/admin-avatar.png') }}" width="40">
                                            </a>
                                            <div class="media-body">
                                                <div class="media-heading">{{ $thread->user->name }} <small class="float-right text-muted">{{ $thread->created_at->diffForHumans() }}</small></div>
                                                <div class="font-13">{!! nl2br(e($thread->comment)) !!}</div>
                                            </div>
                                        </li>
                                        @endforeach
                                    @else
                                        <li>No comments...</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection