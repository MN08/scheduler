@extends('scheduler.app')

{{-- Add 3 indent and empty line before & after --}}
@section('content')

    <header id="page-header">
        <h1>Jam Pelajaran</h1>
        <ol class="breadcrumb">
            <li><a href="#">Edit</a></li>
        </ol>
    </header>

    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default">
            <div class="panel-heading">
                        <span class="title elipsis">
                            <strong>Data Jam Pelajaran</strong>
                        </span>
                {{-- @include('scheduler.partials.help') --}}

                <ul class="options pull-right list-inline">
                    <li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="Colapse" data-placement="bottom"></a></li>
                    <li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="Fullscreen" data-placement="bottom"><i class="fa fa-expand"></i></a></li>
                </ul>
            </div>

            <div class="panel-body">
                {{-- @include('scheduler.partials.alert') --}}

                <form action="{{ route($url,$time->id ?? '') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($time))
                        @method('put')
                    @endif

                    <fieldset>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                                    <label>Waktu Mulai</label>
                                    <input type="text" class="form-control" name="start_time" value="{{old('start_time')?? $time->start_time ?? ''}}">
                                    @error('start_time')

                                    <small class="text-muted block text-danger">{{ $message }}</small>

                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                                    <label>Waktu Selesai</label>
                                    <input type="text" class="form-control" name="end_time" value="{{old('end_time')?? $time->end_time ?? ''}}">
                                    @error('end_time')

                                    <small class="text-muted block text-danger">{{ $message }}</small>

                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="row">
                        <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                            <button type="submit" class="btn btn-3d btn-teal margin-top-30 pull-right">
                                {{ $button }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
