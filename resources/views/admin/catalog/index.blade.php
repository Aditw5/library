@extends('layouts.admin')
@section('header', 'Catalog')
@section('content')
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                <!-- <h3 class="card-title">Bordered Table</h3> -->
                <a href="{{url('catalogs/create')}}" class="btn btn-primary pull-right">Create New Catalog</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th style="width: 40px">Name</th>
                                <th style="width: 40px">Total Books</th>
                                <th style="width: 40px">Created At</th>
                                <th style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($catalogs as $key => $catalog)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$catalog['name']}}</td>
                                <td class="text-center">{{COUNT($catalog['books'])}}</td>
                                <td>{{ custom_date_format($catalog->created_at) }}</td>
                                <td>
                                    <a class="btn btn-warning" href="{{url('catalogs/' .$catalog->id. '/edit')}}">Edit</a>
                                    <form action="{{url('catalogs',['id' => $catalog->id])}}" method="post">
                                    <input class="btn btn-danger" type="submit" value="Delete" onclick="return confirm('Are You Sure?');">
                                        @method('delete')
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>

            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
            </div>  
</div>
</body>
</html>@endsection
