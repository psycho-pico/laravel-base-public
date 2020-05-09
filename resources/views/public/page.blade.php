@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-5">
        {{$maindata->title ?? ''}}</h1>
        <p class="lead">
            {{$maindata->content ?? ''}}
        </p>
    </div>
@endsection
