@extends('layouts.dashboard')

@section('title', __($action . ' ' . $entytyName))

@section('content')
<div class="row mb-4">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            @php
                $backUrl = old('prevPage') ?? url()->previous();
                $backUrlRoute = app('router')->getRoutes()->match(app('request')->create($backUrl))->getName();
                $indexRoute = route(explode(".", Route::currentRouteName())[0] . '.index');
                if (explode(".", $backUrlRoute)[1] != 'index') {
                    $backUrl = $indexRoute;
                }
            @endphp
            <a class="btn btn-primary" href="{{ $backUrl }}"> {{__('Back')}}</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> {{__('There were some problems with your input.')}}<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ __($error) }}</li>
       @endforeach
    </ul>
    <button type="button" class="close">
        <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

<div class="card shadow form-outer" id="main-form-wrapper">
    @if ($action == 'Create')
        {!! Form::open(array('route' => explode(".", Route::currentRouteName())[0] . '.store','method'=>'POST')) !!}
    @elseif ($action == 'Edit' || $action == 'Show')
        {!! Form::model($maindata, ['method' => 'PATCH','route' => [explode(".", Route::currentRouteName())[0] . '.update', $maindata->id]]) !!}
    @endif

    {{ Form::hidden('prevPage', old('prevPage', $backUrl)) }}

    @php
        $isCreate = $action == 'Create' ? true : false;
        $isEdit = $action == 'Edit' ? true : false;
        $isShow = $action == 'Show' ? true : false;
    @endphp

    <div class="card-body">
        <div class="row">
            @foreach($columns as $key => $column)
                @if (($isShow && $column['show']) || ($isCreate && $column['edit']) || ($isEdit && $column['edit']))
                    @php
                        $colGridSize = 'col-xs-12 col-sm-12 col-md-6';
                        if ($column['type'] == 'longtext') {
                            $colGridSize = 'col-xs-12 col-sm-12 col-md-12';
                        }
                    @endphp
                    <div class="{{$colGridSize}}">
                        @if ($isShow)
                            @if ($column['type'] != 'password')
                                <div class="{{$colGridSize}}">
                                    <div class="form-group">
                                        <label class="form-label-text show-only">{{__($key)}}</label>
                                        <div class="form-wrapper-text">

                                            @if ($column['type'] == 'relation')
                                                @if (!is_null($column['relation']) && $column['relation'] == 'hasMany')
                                                    @foreach(${$column['relationRef']} as ${$column['relationRef'].'Key'} => ${$column['relationRef'].'Val'})
                                                        @php
                                                            $checked = $action == 'Edit' || $action == 'Show' ? (in_array(${$column['relationRef'].'Key'}, ${$column['relationMap']}) ? true : false) : false;
                                                        @endphp
                                                        @if ($checked)
                                                            <label class="badge badge-pill badge-success mr-1">{{ ${$column['relationRef'].'Val'} }}</label>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            @elseif ($column['type'] == 'boolean')
                                                <label class="badge badge-pill badge-{{$maindata->{$column['name']} ? 'info' : 'danger'}}">{{$maindata->{$column['name']} ? __('Yes') : __('No')}}</label>

                                            @elseif ($column['type'] == 'timestamp')
                                                @if (!is_null($maindata->{$column['name']}))
                                                    <label class="{{$column['name'] == 'deleted_at' ? 'badge badge-pill badge-danger large' : ''}}">
                                                        {{ Carbon\Carbon::parse($maindata->{$column['name']})->format('d M Y') }}
                                                        <span class="small ml-1">{{ Carbon\Carbon::parse($maindata->{$column['name']})->format('H:i') }}<span class="small">{{ Carbon\Carbon::parse($maindata->{$column['name']})->format(':s') }}</span></span>
                                                    </label>
                                                @else
                                                    @if ($column['name'] == 'deleted_at')
                                                        <span class="text-gray-500 font-italic">no</span>
                                                    @else
                                                        <span class="text-gray-500 font-italic">null</span>
                                                    @endif
                                                @endif

                                            @elseif ($column['type'] == 'route')
                                                <a class="badge badge-pill badge-success pill-url" href="{{ url( $maindata->{$column['name']} ) }}" target="_blank">{{ $maindata->{$column['name']} }}</a>

                                            @else
                                                <span>{{ $maindata->{$column['name']} }}</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if ($column['type'] == 'relation')
                                @if (!is_null($column['relation']) && $column['relation'] == 'hasMany')
                                    <div class="form-group">
                                        <label class="form-label-text">{{__($key)}}</label>
                                        <div class="form-wrapper-text  form-control-cbx">
                                            @foreach(${$column['relationRef']} as ${$column['relationRef'].'Key'} => ${$column['relationRef'].'Val'})
                                                @php
                                                    $checked = $action == 'Edit' || $action == 'Show' ? (in_array(${$column['relationRef'].'Key'}, ${$column['relationMap']}) ? true : false) : false;
                                                @endphp
                                                <div class="inline-block mr-2">
                                                    <label>
                                                        {{ Form::checkbox(($column['name'].'[]'), ${$column['relationRef'].'Val'}, $checked, array('class' => 'name')) }}
                                                        {{ ${$column['relationRef'].'Val'} }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            @elseif ($column['type'] == 'boolean')
                                <div class="form-group">
                                    <label class="form-label-text">{{__($key)}}</label>
                                    <div class="form-wrapper-text form-control-cbx">
                                        <label>
                                            {!! Form::checkbox($column['name'], 1) !!}
                                            <span>{{__($key)}} ?</span>
                                        </label>
                                    </div>
                                </div>

                            @elseif ($column['type'] == 'timestamp')
                                <div class="form-label-group">
                                    {!! Form::text($column['name'], null, array('placeholder' => __($key),'class' => 'form-control', 'id' => ('input' . $column['name']))) !!}
                                    <label for="{{'input' . $column['name']}}">{{__($key)}}</label>
                                </div>

                            @elseif ($column['type'] == 'password')
                                <div class="form-label-group">
                                    {!! Form::password($column['name'], array('placeholder' => __($key),'class' => 'form-control', 'spellcheck' => 'false', 'autocomplete' => 'off', 'id' => ('input' . $column['name']))) !!}
                                    <label for="{{'input' . $column['name']}}">{{__($key)}}</label>
                                </div>

                            @elseif ($column['type'] == 'longtext')
                                <div class="form-label-group">
                                    {!! Form::textarea($column['name'], null, array('placeholder' => __($key),'class' => 'form-control', 'spellcheck' => 'false', 'autocomplete' => 'off', 'id' => ('input' . $column['name']), 'rows' => '3')) !!}
                                    <label for="{{'input' . $column['name']}}">{{__($key)}}</label>
                                </div>

                            @else
                                <div class="form-label-group">
                                    {!! Form::text($column['name'], null, array('placeholder' => __($key),'class' => 'form-control', 'spellcheck' => 'false', 'autocomplete' => 'off', 'id' => ('input' . $column['name']))) !!}
                                    <label for="{{'input' . $column['name']}}">{{__($key)}}</label>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        @if ($action == 'Show')
            @can($permissions['edit'])
                @if (is_null($maindata->deleted_at))
                    <div class="row mt-4">
                        <div class="col-xs-12 col-sm-12">
                            <a class="btn btn-primary" href="{{ route(explode(".", Route::currentRouteName())[0] . '.edit',$maindata->id) }}">{{__('Edit')}}</a>
                        </div>
                    </div>
                @endif
            @endcan
        @endif

        @if ($action == 'Create' || $action == 'Edit')
            <div class="row mt-4">
                <div class="col-xs-12 col-sm-12">
                    <button type="submit" class="btn btn-success">{{__('Submit')}}</button>
                </div>
            </div>
        @endif

    </div>
</div>


@if ($action == 'Create' || $action == 'Edit' || $action == 'Show')
{!! Form::close() !!}
@endif
@endsection
