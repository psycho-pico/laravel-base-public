@extends('layouts.dashboard')

@section('title', __('Create New Role'))

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> {{__('Back')}}</a>
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
    </div>
@endif


{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{__('Name')}}:</strong>
            {!! Form::text('name', null, array('placeholder' => __('Name'),'class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{__('Permission')}}:</strong>
            <div class="row">
                @foreach($permission as $value)
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <label>
                            {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                            {{ $value->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
    </div>
</div>
{!! Form::close() !!}



@endsection
