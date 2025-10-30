@extends('layouts.header')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Access module</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-lg-12">
                        <label class="ui-checkbox mb-2">
                            <input type="checkbox">
                            <span class="input-span"></span>All
                        </label>
                    </div>
                    @foreach ($modules as $module)
                        @if(count($module->submodule) > 0)
                            @foreach ($module->submodule as $submodule)
                            <div class="col-lg-12">
                                <label class="ui-checkbox mb-2">
                                    <input type="checkbox">
                                    <span class="input-span"></span>{{ $submodule->name }}
                                </label>
                            </div>
                            @endforeach
                        @else
                        <div class="col-lg-12">
                            <label class="ui-checkbox mb-2">
                                <input type="checkbox">
                                <span class="input-span"></span>{{ $module->name }}
                            </label>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection