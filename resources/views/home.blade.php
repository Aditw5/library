@extends('layouts.admin')
@section('header', 'Home')
@section('content')

<div class="row">
<div class="col-lg-3 col-6">

<div class="small-box bg-info">
    <div class="inner">
        <h3>150</h3>
        <p>Total Buku</p>
    </div>
        <div class="icon">
            <i class="fas fa-book"></i>
        </div>
            <a href="{{url('books')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-success">
<div class="inner">
<h3>53<sup style="font-size: 20px">%</sup></h3>
<p>Total Anggota</p>
</div>
<div class="icon">
<i class="ion ion-stats-bars"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-warning">
<div class="inner">
<h3>44</h3>
<p>Data Penerbit</p>
</div>
<div class="icon">
<i class="ion ion-person-add"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-danger">
<div class="inner">
<h3>65</h3>
<p>Data Peminjaman</p>
</div>
<div class="icon">
<i class="ion ion-pie-graph"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

</div>
@endsection
