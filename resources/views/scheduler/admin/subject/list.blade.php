@extends('scheduler.app')

{{-- Add 3 indent and empty line before & after --}}
@section('content')

            <header id="page-header">
                <h1>Mata Pelajaran</h1>
                <ol class="breadcrumb">
                    <li><a href="#">List</a></li>
                </ol>
            </header>

            <div id="content" class="padding-20">
                <div id="panel-1" class="panel panel-default">
                    <div class="panel-heading">
                        <span class="title elipsis">
                            <strong>Data Mata Pelajaran</strong>
                        </span>

                        <ul class="options pull-right list-inline">

                            <li>
                                <a href="{{ route('dashboard.subjects.create') }}" class="btn btn-primary btn-xs btn-block">
                                    <i class="fa fa-plus"></i>TAMBAH
                                </a>
                            </li>
                            <li>
                                <a href="#" class="opt panel_colapse" data-toggle="tooltip" title="Colapse" data-placement="bottom"></a>
                            </li>
                            <li>
                                <a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="Fullscreen" data-placement="bottom"><i class="fa fa-expand"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="panel-body">
                       <div class="col-md-12">
                            <div class="row">
                                <ul class="pull-right">
                                    <form method="get" action="{{ route('dashboard.subjects') }}">
                                        <div class="input-group">
                                          <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $request['search'] ?? '' }}" />
                                          <div class="input-group-btn">
                                            <button class="btn btn-primary" type="submit">
                                              <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                          </div>
                                        </div>
                                    </form>
                                </ul>
                            </div>
                       </div>

                        <table id="General-DataTables" data-resources="" class="table table-striped table-bordered table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kode Mapel</th>
                                    <th>Kelas</th>
                                    <th>Jumlah Jam</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            @foreach ($subjects as $subject)
                            <tr>
                                <th scope="row">{{ ($subjects->currentPage()-1) *$subjects->perPage() + $loop->iteration  }}</th>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->code }}</td>
                                <td>{{ $subject->grade }}</td>
                                <td>{{ $subject->available_time }}</td>
                                <td>
                                    <a href="{{ route('dashboard.subjects.edit',['id' => $subject->id]) }}" class="btn btn-info btn-sm"><b class="fa fa-edit"></b> Ubah</a>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $subject->id }}">
                                        <b class="fa fa-trash"></b> Hapus
                                    </button>
                                    <div class="modal fade" id="modal-delete-{{ $subject->id }}">
                                        <div class="modal-dialog ">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary-rapo">
                                                    <button class="close text-white" data-dismiss="modal"><span class="fa fa-times"></span></button>
                                                    <h4 class="modal-title text-white">Hapus Kelas</h4>
                                                  </div>
                                            </div>
                                            <div class="modal-body" style="background-color: white;">
                                                <p>Apakah anda yakin ingin menghapus class <strong>{{ $subject->name }}</strong> ?</p>
                                            </div>
                                            <div class="modal-footer" style="background-color: white;">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                                                <form action="{{route('dashboard.subjects.delete',['id' => $subject->id])  }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm"><b class="fa fa-trash"></b> Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                        <div class="pull-right">
                            {{$subjects->appends($request)->links('pagination::bootstrap-4')}}
                    </div>

                    <div class="panel-footer">
                    </div>
                </div>
            </div>



@endsection
