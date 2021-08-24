@extends('scheduler.app')

{{-- Add 3 indent and empty line before & after --}}
@section('content')

    <header id="page-header">
        <h1>Mata Pelajaran</h1>
        <ol class="breadcrumb">
            <li><a href="#">Form</a></li>
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
                                    <select class="form-control" id="teacher_id" name="teacher_id">
                                        <option value=""> --Silahkan Pilih-- </option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}"  {{ (isset($teacher->id) || old('id'))? "selected":"" ?? "" }}>{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')

                                    <small class="text-muted block text-danger">{{ $message }}</small>

                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                                    <label>Mata Pelajaran</label>
                                    <select class="form-control" id="subject_id" name="subject_id">
                                        <option value=""> -- Select One --</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ (isset($subject->id) || old('id'))? "selected":"" ?? "" }}>{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')

                                    <small class="text-muted block text-danger">{{ $message }}</small>

                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-md-offset-3 col-md-6 col-sm-6">
                                <label>Kelas Diampu</label>
                                <input type="number" class="form-control" name="grade" value="{{ old('grade') ?? $teachersubject->grade ?? '' }}">
                                @error('grade')

                                <small class="text-muted block text-danger">{{ $message }}</small>

                                @enderror
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
        </div>
    </div>

@endsection
