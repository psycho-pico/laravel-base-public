@extends('layouts.dashboard')

@section('title', __($entytyName))


@section('content')

@php
    $columnSearchables = array_filter($columns, function ($var) {
        return (isset($var['search']) && !is_null($var['search']));
    });
    $columnHasDeleted = array_filter($columns, function ($var) {
        return (isset($var['name']) && $var['name'] == 'deleted_at');
    });

    $hasDelete = !empty($columnHasDeleted);

    $search_panel_collapsed = Auth::user()->getPreference->search_panel_collapsed ?? false;

    $controllerPerpage = $maindatas->perPage();
    $preferencePerpage = Auth::user()->getPreference->table_row_per_page ?? $controllerPerpage;
    $getPerpage = app('request')->input('perpage') && is_numeric(app('request')->input('perpage')) ? app('request')->input('perpage') : $preferencePerpage;

    if ($getPerpage == $controllerPerpage) {
        $perpage = (int)$getPerpage;
    }
    else {
        $perpage = (int)$preferencePerpage;
    }

@endphp

@if (!empty($columnSearchables))
{!! Form::open(array('route' => explode(".", Route::currentRouteName())[0] . '.index','method'=>'GET', 'id' => 'search-form')) !!}

{{ Form::hidden('o', app('request')->input('o')) }}
{{ Form::hidden('s', app('request')->input('s')) }}
{{ Form::hidden('perpage', $perpage) }}
@can ('deleted-view')
    @if ($hasDelete)
        {{ Form::hidden('del', app('request')->input('del'), ['data-input-grpup' => 'del']) }}
        {{ Form::hidden('withDel', app('request')->input('withDel'), ['data-input-grpup' => 'del']) }}
    @endif
@endcan

<div id="searchPanelOuter">
    <div id="searchPanelWrapper" class="card shadow mb-3 search-outer">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between search-header {{$search_panel_collapsed ? 'collapsed' : ''}} search-panel-toggler" data-toggle="collapse" data-target="#searchBodyWrapper" aria-expanded="true" aria-controls="searchBodyWrapper">
         {{__('Search')}}
      </div>
      <div id="searchBodyWrapper" class="collapse {{$search_panel_collapsed ? '' : 'show'}}" aria-labelledby="headingOne" data-parent="#searchPanelWrapper">
        <div class="card-body">
          <div class="row">
              @foreach ($columnSearchables as $columnSearchableKey => $columnSearchableVal)
                  @if ($columnSearchableVal['search'] == 'string')
                      <div class="col-xs-12 col-sm-12 col-md-6">
                          <div class="form-label-group">
                              {!! Form::text($columnSearchableVal['name'], app('request')->input($columnSearchableVal['name']), array('placeholder' => __($columnSearchableKey),'class' => 'form-control', 'spellcheck' => 'false', 'autocomplete' => 'off', 'id' => ('input' . $columnSearchableVal['name']))) !!}
                              <label for="{{'input' . $columnSearchableVal['name']}}">{{__($columnSearchableKey)}}</label>
                          </div>
                      </div>
                  @elseif ($columnSearchableVal['search'] == 'boolean')
                      <div class="col-xs-12 col-sm-12 col-md-6">
                          <div class="form-group">
                              <label class="form-label-text">{{__($columnSearchableKey)}}</label>
                              <div class="form-wrapper-text form-control-cbx">
                                  <label class="mr-2">
                                      {!! Form::radio($columnSearchableVal['name'], 1, app('request')->input($columnSearchableVal['name']) == 1 ? 1 : 0) !!}
                                      {{_('Yes')}}
                                  </label>
                                  <label>
                                      {!! Form::radio($columnSearchableVal['name'], 0, null !== app('request')->input($columnSearchableVal['name']) && app('request')->input($columnSearchableVal['name']) == 0 ? 1 : 0) !!}
                                      {{_('No')}}
                                  </label>
                              </div>
                          </div>
                      </div>
                  @endif
              @endforeach
          </div>

          <div class="row">
              <div class="col-xs-12 col-sm-12">
                  <button type="submit" class="btn btn-primary mr-2 mb-1">{{__('Search')}}</button>
                  <a class="btn btn-light clear-search-btn mb-1" href="{{ route(explode(".", Route::currentRouteName())[0] . '.index') }}">{{__('Clear')}}</a>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
{!! Form::close() !!}
@endif


@if ($message = session('success') ?? session('fail'))
<div class="alert alert-{{session('success') ? 'success' : 'danger'}}">
    <p>{{ $message }}</p>
    {{-- <p>{{ Session::get() }}</p> --}}
    <button type="button" class="close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div id="mainTableWrapperOuter">
    <div class="card table-wrapper" id="mainTableWrapper">
        <div class="card-header">
            <div class="d-flex table-wrapper-header-action">
                <div class="mr-auto header-action-left">
                    @can($permissions['create'])
                    <a class="btn btn-primary btn-lg" href="{{ route(explode(".", Route::currentRouteName())[0] . '.create') }}" title="{{__('Create new ' . $entytyName)}}" data-toggle="tooltip" data-placement="bottom"> {{__('Add')}}</a>
                    @endcan
                </div>
                <div class="d-flex header-action-right horizontal-scroll horizontal-scroll-sm">
                    @can ('deleted-view')
                        @if ($hasDelete)
                            <div class="d-flex mr-2 header-action-right-item btn-group-wrapper">
                                <a href="#!" class="btn btn-group btn-filter filter-btn {{null !== app('request')->del && app('request')->del == '1' ? 'active' : ''}}" data-filter-group="del" data-filter-name="del">{{__('Deleted')}}
                                </a><a href="#!" class="btn btn-group btn-filter filter-btn {{null !== app('request')->withDel && app('request')->withDel == '1' ? 'active' : ''}}" data-filter-group="del" data-filter-name="withDel">{{__('All')}}</a>
                            </div>
                            @endif
                        @endcan
                    <div class="d-flex header-action-right-item">
                        <a href="#!" id="ddlPerpage" class="btn btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$perpage}}</a>
                        <div class="dropdown-menu" aria-labelledby="ddlPerpage">
                            @forelse ($perpages as $perpageKey => $perpage)
                                <a class="dropdown-item perpage-number" href="#!">{{$perpage->per_page}}</a>
                            @empty
                                <a class="dropdown-item perpage-number" href="#!">10</a>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="card-middle">
                <div class="float-md-right small text-gray-500 mt-2 mb-1">
                    {{_('Show')}}
                    @if (count($maindatas) != $maindatas->total())
                        <span class="text-gray-600 font-weight-bold">{{count($maindatas)}}</span> /
                    @endif
                    <span class="text-gray-600 font-weight-bold">{{ $maindatas->total() }}</span> {{_('data')}}
                </div>
            </div>
            <div class="table-inner horizontal-scroll w-100">
                <table class="table table-reference">
                    <thead>
                        <tr>
                            <th width="40px">{{__('No')}}</th>
                            @foreach($columns as $key => $column)
                                @if ($column['index'])
                                    @if (($column['name'] != 'deleted_at') || ($column['name'] == 'deleted_at' && (app('request')->input('del') == '1' || app('request')->input('withDel') == '1')))
                                        @php
                                        $width_th = 'width=';
                                        if ($column['name'] == 'deleted_at') {
                                            $width_th_val = $width_th . '120px';
                                        }
                                        $searchable = $column['search'] ?? false;
                                        $searchable_dir = '';
                                        if (app('request')->input('o') == $column['name']) {
                                            if (app('request')->input('s') == 'desc') {
                                                $searchable_dir = 'up';
                                            }
                                            else {
                                                $searchable_dir = 'down';
                                            }
                                        }
                                        @endphp
                                        <th class="{{$searchable ? 'th-searchable' : ''}} {{$searchable_dir}}" {{$searchable ? 'data-search='.$column['name'] : ''}} {{$width_th_val ?? ''}}>
                                            {{__($key)}}
                                        </th>
                                    @endif
                                @endif
                            @endforeach
                            <th width="70px">{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($maindatas as $key => $maindata)
                            @php
                                $isdeleted = $maindata->deleted_at ? 'deleted' : '';
                            @endphp
                        <tr class="{{$isdeleted}}">
                            <td>{{ ++$i }}</td>
                            @foreach($columns as $key => $column)
                                @php
                                $isDeletedShow = ($column['name'] != 'deleted_at') || ($column['name'] == 'deleted_at' && (app('request')->input('del') == '1' || app('request')->input('withDel') == '1'));
                                @endphp
                                @if ($column['index'] && $isDeletedShow)
                                    <td>
                                        @if (!is_null($maindata->{$column['name']}) && $column['type'] != 'relation')
                                            @if ($column['type'] == 'boolean')
                                                {{ __($maindata->{$column['name']} ? 'Yes' : 'No') }}
                                            @elseif ($column['type'] == 'timestamp')
                                                <span class="{{$column['name'] == 'deleted_at' ? 'badge badge-pill badge-danger' : ''}}">{{ Carbon\Carbon::parse($maindata->{$column['name']})->format('d M Y') }}</span>
                                            @elseif ($column['type'] == 'longtext')
                                                {{ Str::limit($maindata->{$column['name']}, 50, '...') }}
                                            @elseif ($column['type'] == 'route')
                                                <a class="badge badge-pill badge-success pill-url" href="{{ url( $maindata->{$column['name']} ) }}" target="_blank">{{ $maindata->{$column['name']} }}</a>
                                            @else
                                                {{ $maindata->{$column['name']} }}
                                            @endif
                                        @elseif ($column['type'] == 'relation')
                                            @if (!is_null($column['relation']) && $column['relation'] == 'hasMany')
                                                @if(!empty($maindata->{$column['method']}()))
                                                    @foreach($maindata->{$column['method']}() as $v)
                                                        <label class="badge badge-pill badge-success">{{ $v }}</label>
                                                    @endforeach
                                                @endif
                                            @endif
                                        @else
                                            @if ($column['name'] == 'deleted_at')
                                                <span class="text-gray-500 font-italic">no</span>
                                            @else
                                                <span class="text-gray-500 font-italic">null</span>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                            <td>
                                <a class="btn btn-circle btn-light action-reference-table-trigger" href="#!" title="{{__('Action')}}" id="action-p{{$maindata->id}}co" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>

                                <div class="dropdown-menu action-reference-table" aria-labelledby="action-p{{$maindata->id}}co">

                                    <a class="dropdown-item" href="{{ route(explode(".", Route::currentRouteName())[0] . '.show',$maindata->id) }}"><i class="fas fa-eye mr-2 show"></i> {{__('Show')}}</a>

                                    @can($permissions['edit'])
                                        @if (is_null($maindata->deleted_at))
                                            <a class="dropdown-item" href="{{ route(explode(".", Route::currentRouteName())[0] . '.edit',$maindata->id) }}"><i class="fas fa-pen mr-2 edit"></i> {{__('Edit')}}</a>
                                        @endif
                                    @endcan

                                    @can($permissions['delete'])
                                        @if (is_null($maindata->deleted_at))
                                            {!! Form::open(['method' => 'DELETE','route' => [explode(".", Route::currentRouteName())[0] . '.destroy', $maindata->id],'style'=>'display:inline', 'class' => 'del-form']) !!}
                                            <button type="submit" class="dropdown-item"><i class="fas fa-trash mr-2 delete"></i> {{__('Delete')}}</button>
                                            {!! Form::close() !!}
                                        @endif
                                    @endcan

                                    @can('deleted-view')
                                        @if (!is_null($maindata->deleted_at))
                                            <a class="dropdown-item restore-btn" href="{{ route(explode(".", Route::currentRouteName())[0] . '.restore', $maindata->id) }}"><i class="fas fa-trash-restore mr-2 restore"></i> {{__('Restore')}}</a>

                                            <a class="dropdown-item burn-btn" href="{{ route(explode(".", Route::currentRouteName())[0] . '.burn', $maindata->id) }}"><i class="fas fa-fire mr-2 burn"></i> {{__('Burn')}}</a>
                                        @endif
                                    @endcan
                                </div>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            @php
                                $additionColumnNumber = 1;
                                if ($column['name'] == 'deleted_at' && (app('request')->input('del') == '1' || app('request')->input('withDel') == '1')) {
                                    $additionColumnNumber =+1;
                                }
                            @endphp
                            <td colspan="{{count($columns) + $additionColumnNumber}}" class="text-center">{{__('No record')}}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="horizontal-scroll mt-3">
    {!! $maindatas->render() !!}
</div>



@endsection
