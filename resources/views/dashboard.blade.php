@extends('layouts.admin')
@section('header', 'Home')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
@endsection

@section('content')

<div class="row">
    <!-- Box 1: Total Books -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$total_buku}}</h3>
                <p>Total Books</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <a href="{{url('books')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box 2: Total Members -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$total_anggota}}</h3>
                <p>Total Members</p>
            </div>
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
            <a href="{{url('members')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box 3: Total Publishers -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$total_penerbit}}</h3>
                <p>Total Publishers</p>
            </div>
            <div class="icon">
                <i class="fas fa-upload"></i>
            </div>
            <a href="{{url('publishers')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box 4: Total Transactions -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$total_peminjaman}}</h3>
                <p>Total Transactions</p>
            </div>
            <div class="icon">
                <i class="fas fa-download"></i>
            </div>
            <a href="{{url('transactions')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Publisher Chart</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Transaction Chart</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Authorr Chart</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="authorChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('assets/dist/js/adminlte.min.js?v=3.2.0')}}"></script>
<script src="{{asset('assets/dist/js/demo.js')}}"></script>
<script>
    var data_donut = {!! json_encode($data_donut) !!};
    var label_donut = {!! json_encode($label_donut) !!};
    var data_author = {!! json_encode($data_author) !!};
    var label_author = {!! json_encode($label_author) !!};
    var data_bar = {!! json_encode($data_bar) !!};
    console.log(data_bar);

    $(function () {
        // Bar Chart Data
        var barChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: data_bar
        };

        var barChartCanvas = $('#barChart').get(0).getContext('2d');

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions,
        });

        // Donut Chart Data
        var donutData = {
            labels: label_donut,
            datasets: [
                {
                    data: data_donut,
                    backgroundColor: [
                        '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
                        '#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#fd7e14', '#20c997',
                        '#17a2b8', '#ffc107', '#343a40', '#6c757d', '#343a40', '#6c757d',
                    ],
                },
            ],
        };

        var donutChartCanvas = $('#donutChart').get(0).getContext('2d');

        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        };

        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions,
        });

        // Author Chart Data
        var authorData = {
            labels: label_author,
            datasets: [
                {
                    data: data_author,
                    backgroundColor: [
                        '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de',
                        '#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#fd7e14', '#20c997',
                        '#17a2b8', '#ffc107', '#343a40', '#6c757d', '#343a40', '#6c757d',
                    ],
                },
            ],
        };

        var authorChartCanvas = $('#authorChart').get(0).getContext('2d');

        var authorOptions = {
            maintainAspectRatio: false,
            responsive: true,
        };

        new Chart(authorChartCanvas, {
            type: 'doughnut',
            data: authorData,
            options: authorOptions,
        });
    });
</script>
@endsection
