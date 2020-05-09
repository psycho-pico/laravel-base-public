@extends('layouts.app')

@section('content')
    <h1 class="mt-5">
      {{$maindata->title ?? ''}}</h1>
    <p class="lead">
      {{$maindata->content ?? ''}}
    </p>
@endsection
