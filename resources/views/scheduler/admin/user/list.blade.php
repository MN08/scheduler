@extends('scheduler.app')

{{-- Add 3 indent and empty line before & after --}}
@section('content')

            <header id="page-header">
                <h1>Users</h1>
                <ol class="breadcrumb">
                    <li><a href="#">List</a></li>
                </ol>
            </header>

            <div id="content" class="padding-20">
                <div id="panel-1" class="panel panel-default">
                    <div class="panel-heading">
                        <span class="title elipsis">
                            <strong>Data User</strong>
                        </span>

                        <ul class="options pull-right list-inline">

                            <li>
                                <a href="" class="btn btn-primary btn-xs btn-block">
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
                        <table id="General-DataTables" data-resources="" class="table table-striped table-bordered table-hover" style="width: 100%;">

                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Registered</th>
                            </tr>
                            @foreach ($users as $user)
                            <tr>
                                <td>1</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                            @endforeach

                        </table>
                        {{ $users->links() }}
                    </div>

                    <div class="panel-footer">
                    </div>
                </div>
            </div>

@endsection
