@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            Week :
                            <input type="week" name="week" class="form-control">
                        </div>
                        <div class="col-md-4">
                            &nbsp;
                            <div><button type="submit" class="btn btn-success">Filter</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">

            </div>
            <div class="ibox-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hober">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Issues</th>
                                <th>Closed</th>
                                <th>Ongoing</th>
                                <th>Hold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td>{{ $d->category_name }}</td>
                                <td>{{ $d->issues }}</td>
                                <td>{{ $d->closed }}</td>
                                <td>{{ $d->ongoing }}</td>
                                <td>0</td>
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