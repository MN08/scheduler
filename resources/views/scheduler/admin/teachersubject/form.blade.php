@extends('scheduler.app')

{{-- Add 3 indent and empty line before & after --}}
@section('content')

    <header id="page-header">
        <h1>Mata Pelajaran</h1>
        <ol class="breadcrumb">
            <li><a href="#">Edit</a></li>
        </ol>
    </header>

    <div id="content" class="padding-20">
        <div id="panel-1" class="panel panel-default">
            <div class="panel-heading">
                        <span class="title elipsis">
                            <strong>Data Mata Pelajaran</strong>
                        </span>
                {{-- @include('scheduler.partials.help') --}}

                <ul class="options pull-right list-inline">
                    <li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="Colapse" data-placement="bottom"></a></li>
                    <li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="Fullscreen" data-placement="bottom"><i class="fa fa-expand"></i></a></li>
                </ul>
            </div>

            <div class="panel-body">
                {{-- @include('scheduler.partials.alert') --}}

                <form action="{{ route($url,$teachersubject->id ?? '') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($teachersubject))
                        @method('put')
                    @endif

                    <fieldset>


                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                                    <label>Nama Guru</label>
                                    <select id="teacher_id" name="teacher_id" class="form-control pointer" data-sources="{{ route('dashboard.teachers') }}" data-placeholder="--- Select ---" data-selected="{{ old('teacher_id') ?? $teachersubject->teacher_id ?? '' }}"></select>
                                    @error('teacher_id')

                                    <small class="text-muted block text-danger">{{ $message }}</small>

                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                                    <label>Nama Guru</label>
                                    <select id="subject_id" name="subject_id" class="form-control pointer" data-sources="{{ route('dashboard.subjects') }}" data-placeholder="--- Select ---" data-selected="{{ old('subject_id') ?? $teachersubject->subject_id ?? '' }}"></select>
                                    @error('subject_id')

                                    <small class="text-muted block text-danger">{{ $message }}</small>

                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                                    <label>Kelas Diampu</label>
                                    <select id="room_id" name="room_id" class="form-control pointer" data-sources="{{ route('dashboard.rooms') }}" data-placeholder="--- Select ---" data-selected="{{ old('room_id') ?? $teachersubject->room_id ?? '' }}"></select>
                                    @error('room_id')

                                    <small class="text-muted block text-danger">{{ $message }}</small>

                                    @enderror
                                </div>
                            </div>
                        </div>

                            {{-- <div class="form-group">
                                <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                                    <label>Jumlah Jam</label>
                                    <input type="number" class="form-control" name="available_time" value="{{old('available_time')?? $subject->available_time }}">
                                    @error('available_time')

                                    <small class="text-muted block text-danger">{{ $message }}</small>

                                    @enderror
                                </div>
                            </div> --}}
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

            <div class="panel-footer"></div>
        </div>
    </div>

@endsection
