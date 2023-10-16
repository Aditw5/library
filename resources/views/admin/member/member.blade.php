@extends('layouts.admin')
@section('header', 'Member')

@section('css')
<!-- plugins Data Table -->
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div id="controller" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                             <a href="#" @click="addData()" class="btn btn-primary pull-right">Create New Member</a>
                        </div>
                        <div class="col-md-2">
                            <select name="gender" class="form-control" id="">
                                <option value="0">Semua Jenis Kelamin</option>
                                <option value="F">Perempuan</option>
                                <option value="M">Laki-Laki</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >No</th>
                                <th >Name</th>
                                <th >Gender</th>
                                <th >Phone Number</th>
                                <th >Address</th>
                                <th >Email</th>
                                <th >Created At</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                    </table>
            </div>
    </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form :action="actionUrl" method="post" autocomplete="off" @submit="submitForm($event, data.id)">
                        <div class="modal-header">
                            <h4 class="modal-title">Member</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" :value="data.name" type="text" required="" class="form-control" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" :value="data.gender"  name="gender" required autocomplete="off">
                                    <option value="">Pilih Layanan</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                                <!-- <input name="gender" :value="data.gender" type="text" required="" class="form-control" placeholder="Enter Gender"> -->
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input :value="data.phone_number" name="phone_number" type="text" required="" class="form-control" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input :value="data.address" name="address" type="text" required="" class="form-control" placeholder="Enter Address">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input :value="data.email" name="email" type="email" required="" class="form-control" placeholder="Enter Email">
                            </div>
                            
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
            </div>
        </div>
</div>
@endsection

@section('js')
<!-- Plugins Data Table -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript">
    var actionUrl = '{{url('members')}}'
    var apiUrl = '{{url('api/members')}}'

    console.log(actionUrl)

    var columns = [
        {data: 'DT_RowIndex', class: 'text-center', orderable: false},
        {data: 'name', class: 'text-center', orderable: false},
        {data: 'gender', class: 'text-center', orderable: false},
        {data: 'phone_number', class: 'text-center', orderable: true},
        {data: 'address', class: 'text-center', orderable: true},
        {data: 'email', class: 'text-center', orderable: true},
        {data: 'created_at', class: 'text-center', orderable: true},
        {render: function (data, index, row, meta) {
            return `
                <a class="btn btn-warning" onclick="controller.editData(event, ${meta.row})" href="#">
                    Edit
                </a>
                <a class="btn btn-danger" onclick="controller.deleteData(event, ${row.id})" href="#">
                    Delete
                </a>`;
        }, orderable: false, width: '200px', class: 'text-center'},
    ];
</script>
<script src="{{ asset('js/data.js') }}"></script>
<script type="text/javascript">
    $('select[name=gender]').on('change', function() {
        gender = $('select[name=gender]').val();

        // Periksa jika gender adalah "Semua Jenis Kelamin"
        if (gender == 0) {
            // Kirim filter kosong (tanpa gender) ke server
            controller.table.ajax.url(actionUrl).load();
        } else {
            // Kirim gender yang dipilih ke server sebagai filter
            controller.table.ajax.url(actionUrl+'?gender='+gender).load();
        }
    })
</script>

@endsection