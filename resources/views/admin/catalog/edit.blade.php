@extends('layouts.admin')
@section('header', 'Catalog')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Edit Catalog</h3>
                </div>
                    <form method="post" action="{{url('catalogs/'.$catalog->id)}}">
                    @csrf
                    {{method_field('put')}}
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" value="{{ $catalog->name }}"  type="text" required="" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection