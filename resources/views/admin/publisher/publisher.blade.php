@extends('layouts.admin')
@section('header', 'Publisher')

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
                <!-- <h3 class="card-title">Bordered Table</h3> -->
                <a href="#" @click="addData()" class="btn btn-primary pull-right">Create New Publisher</a>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >No</th>
                                <th >Name</th>
                                <th >Email</th>
                                <th >Phone Number</th>
                                <th >Address</th>
                                <!-- <th >Total Books</th> -->
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
                            <h4 class="modal-title">Publisher</h4>
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
                                <label>Email</label>
                                <input :value="data.email" name="email" type="email" required="" class="form-control" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input :value="data.phone_number" name="phone_number" type="text" required="" class="form-control" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input :value="data.address" name="address" type="text" required="" class="form-control" placeholder="Enter Address">
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
    var actionUrl = '{{url('authors')}}'
    var apiUrl = '{{url('api/authors')}}'

    var columns = [
        {data: 'DT_RowIndex', class: 'text-center', orderable: false},
        {data: 'name', class: 'text-center', orderable: false},
        {data: 'email', class: 'text-center', orderable: true},
        {data: 'phone_number', class: 'text-center', orderable: true},
        {data: 'address', class: 'text-center', orderable: true},
        // {
        //     data: null,
        //     class: 'text-center',
        //     render: function (data, type, row) {
        //         var totalBooks = 0;
        //         if (data.books && Array.isArray(data.books)) {
        //             totalBooks = data.books.length;
        //         }
        //         return totalBooks;
        //     },
        //     orderable: true,
        // },
        { 
            data: 'created_at', render: function (data, type, row) {
                return custom_date_format(data);
            }, class: 'text-center', orderable: true },
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
<!-- <script>
  $(function () {
    $("#example2").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
  });
</script> -->

<!-- <script type="text/javascript">
        var controller = new Vue({
            el: '#controller',
            data: {
                data: {},
                actionUrl : '{{ url('publishers') }}',
                editStatus : false
            },
            mounted: function (){

            },
            methods: {
                addData() {
                    this.data = {};
                    this.actionUrl = '{{ url('publishers') }}';
                    this.editStatus = false
                    $('#modal-default').modal();
                    // console.log('add data');
                },
                editData(data) {
                    // console.log(data)
                    this.data = data;
                    this.actionUrl = '{{ url('publishers') }}'+'/'+data.id;
                    this.editStatus = true
                    $('#modal-default').modal();
                },
                deleteData(id) {
                    // console.log(id)
                    this.actionUrl = '{{ url('publishers') }}'+'/'+id;
                    if (confirm("Are You Sure ?")) {
                        axios.post(this.actionUrl, {_method: 'DELETE'}).then(response => {
                            location.reload();
                        });
                    }
                },
            }
        });
    </script> -->
@endsection