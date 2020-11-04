@extends('layouts.app')

@section('title')
    Profile - X
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @if(isset($animes) && (count($animes) > 0))
                <div class="col-xl-3 col-sm-6 py-2">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body bg-info">
                            <div class="rotate">
                                <i class="fa fa-user fa-4x"></i>
                            </div>
                            <h6 class="text-uppercase">Animes</h6>
                            <h1 class="display-4">{{count($animes)}}</h1>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h2>News animes added</h2>
            </div>
            <div class="col-12">
                <table class="table table-bordered yajra-datatable w-100">
                    <thead>
                    <tr>
                        <td>No</td>
                        <td>Title</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {
            const table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
            const a = 4;
        });
    </script>
@endsection
