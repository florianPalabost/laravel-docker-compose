@extends('layouts.app')

@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            @isset($animes)
                <div class="col-xl-2 col-sm-6">
                    <div class="card bg-primary text-white">
                        <div class="card-body bg-primary">
                            <h6 class="text-uppercase">Animes</h6>
                            <h1 class="display-4">{{count($animes)}}</h1>
                        </div>
                    </div>
                </div>
            @endisset
            @isset($statsAnimes)
                @foreach($statsAnimes as $prop => $nbProp)
                    <div class="col-xl-2 col-sm-6">
                        <div class="card bg-info text-white">
                            <div class="card-body bg-info">
                                <h6 class="text-uppercase">{{str_replace('_', ' ', $prop)}}</h6>
                                <h1 class="display-4">{{$nbProp}}</h1>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endisset
        </div>

        <div class="row mt-5">
            <div class="col-4 mx-auto">
                <h2>% du nombre d'animes par genre</h2>
                <canvas id="chartPie" width="250" height="250"></canvas>
            </div>
            <div class="col-4 mx-auto">
                <h2>Représentation du nombre d'animes par genre</h2>
                <canvas id="myChart" width="250" height="250"></canvas>
            </div>
        </div>

{{--        <div class="row mt-5">--}}
{{--            <div class="col-12">--}}
{{--                <h2>News animes added</h2>--}}
{{--            </div>--}}
{{--            <div class="col-12">--}}
{{--                <table class="table table-bordered yajra-datatable w-100">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <td>No</td>--}}
{{--                        <td>Title</td>--}}
{{--                        <td>Action</td>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

{{--        </div>--}}
    </div>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
@endsection
@push('script')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {
            const jsonData = JSON.parse('<?= $genres; ?>');

            const labels = jsonData.map(genre => genre.name);
            const animesCount = jsonData.map(genre => genre.animes);

            createChart('radar', 'myChart', labels, animesCount);
            createChart('pie', 'chartPie', labels, animesCount);



            {{--const table = $('.yajra-datatable').DataTable({--}}
            {{--    processing: true,--}}
            {{--    serverSide: true,--}}
            {{--    ajax: "{{ route('dashboard') }}",--}}
            {{--    columns: [--}}
            {{--        {data: 'DT_RowIndex', name: 'DT_RowIndex'},--}}
            {{--        {data: 'title', name: 'title'},--}}
            {{--        {--}}
            {{--            data: 'action',--}}
            {{--            name: 'action',--}}
            {{--            orderable: true,--}}
            {{--            searchable: true--}}
            {{--        },--}}
            {{--    ]--}}
            {{--});--}}
        });

        const createChart = (canvasType, canvasId, labels, values) => {
            const ctx = document.getElementById(canvasId).getContext('2d');
            const data = {
                labels,
                datasets: [{
                    label: 'Count animes by genre',
                    data: values
                }]
            };
            const options = {
                plugins: {
                    colorschemes: {
                        scheme: 'brewer.Paired12'
                    }
                }
            };

            const myChart = new Chart(ctx, {
                type: canvasType,
                data,
                options
            });
        };
    </script>
@endpush
