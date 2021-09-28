@extends('scheduler.app')

{{-- Add 3 indent and empty line before & after --}}
@section('content')

            <header id="page-header">
                <h1>Hari</h1>
                <ol class="breadcrumb">
                    <li><a href="#">List</a></li>
                </ol>
            </header>

            <div id="content" class="padding-20">
                <div id="panel-1" class="panel panel-default">
                    <div class="panel-heading">
                        <span class="title elipsis">
                            <strong>Data Hari</strong>
                        </span>

                        <ul class="options pull-right list-inline">

                            <li>
                                <a href="{{ route('dashboard.days.create') }}" class="btn btn-primary btn-xs btn-block">
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
                        @if ($days->total())
                       <div class="col-md-12">
                            <div class="row">
                                <ul class="pull-right">
                                    <form method="get" action="{{ route('dashboard.days') }}">
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
                                    <th>Hari</th>
                                    <th>Jumlah Slot</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            @foreach ($days as $day)
                            <tr>
                                <th scope="row">{{ ($days->currentPage()-1) *$days->perPage() + $loop->iteration  }}</th>
                                <td>{{ $day->name }}</td>
                                <td>{{ $day->slot }}</td>
                                <td>
                                    <a href="{{ route('dashboard.days.edit',$day->id) }}" class="btn btn-info btn-sm"><b class="fa fa-edit"></b> Ubah</a>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{ $day->id }}">
                                        <b class="fa fa-trash"></b> Hapus
                                    </button>
                                    <div class="modal fade" id="modal-delete-{{ $day->id }}">
                                        <div class="modal-dialog ">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary-rapo">
                                                    <button class="close text-white" data-dismiss="modal"><span class="fa fa-times"></span></button>
                                                    <h4 class="modal-title text-white">Hapus Hari</h4>
                                                  </div>
                                            </div>
                                            <div class="modal-body" style="background-color: white;">
                                                <p>Apakah anda yakin ingin menghapus Hari <strong>{{ $day->name."dengan slot"." ".$day->slot }}</strong> ?</p>
                                            </div>
                                            <div class="modal-footer" style="background-color: white;">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                                                <form action="{{route('dashboard.days.delete',$day->id)  }}" method="POST">
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
                            {{$days->appends($request)->links('pagination::bootstrap-4')}}
                        </div>

                        @else
                            <h4 class="text-center p-3">Data Kelas Belum Ada</h4>
                        @endif

                    <div class="panel-footer">
                    </div>
                </div>
            </div>



@endsection
