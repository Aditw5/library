@extends('layouts.admin')

@section('header', 'Transaction Detail')

@push('css')
<style>
    .tampil-pay {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    .table-transaction tbody tr:last-child {
        display: none;
    }

    @media(max-width: 768px) {
        .tampil-pay {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush


@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <table>
                    <tr>
                        <td>Supplier</td>
                        <td>: {{ $member->name }}</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>: {{ $member->phone_number }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>: {{ $member->address }}</td>
                    </tr>
                </table>
            </div>
            <div class="box-body">
                    
                <form class="form-book">
                    @csrf
                    <div class="form-group row">
                        <label for="title" class="col-lg-2">Book Title</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="transaction_id" id="transaction_id" value="{{ $transaction_id }}">
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="form-control" name="title" id="title">
                                <span class="input-group-btn">
                                    <button onclick="tampilBook()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-stiped table-bordered table-transaction">
                    <thead>
                        <th width="5%">No</th>
                        <th>Title</th>
                        <th>Qty</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-pay bg-primary"></div>

                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('transactions.store') }}" class="form-transaction" method="post">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">
                            <input type="hidden" name="qty" id="qty">

                            <div class="form-group row">
                                <label for="date_start" class="col-lg-2 control-label">Date Start</label>
                                <div class="col-lg-8">
                                    <input type="date" name="date_start" id="date_start" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pay" class="col-lg-2 control-label">Date End</label>
                                <div class="col-lg-8">
                                    <input type="date" name="date_end" id="date_end" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>

@includeIf('admin.transaction_detail.book')
@endsection
@section('js')
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
<script>
    let table, table2;
    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-transaction').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaction_detail.data', $transaction_id) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'title'},
                {data: 'qty'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
       
        table2 = $('.table-book').DataTable();

        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let qty = parseInt($(this).val());

            if (qty < 1) {
                $(this).val(1);
                alert('Jumlah tidak boleh kurang dari 1');
                return;
            }
            if (qty > 10000) {
                $(this).val(10000);
                alert('Jumlah tidak boleh lebih dari 10000');
                return;
            }

            $.post(`{{ url('transaction_detail') }}/${id}`, {
                    '_token': '{{csrf_token()}}',
                    '_method': 'put',
                    'qty': qty
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload();
                    });
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        });

        $(document).on('input', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });

        $('.btn-simpan').on('click', function () {
            $('.form-transaction').submit();
        });
    });
   
    function tampilBook() {
        $('#modal-book').modal('show');
    }

    function hideBook() {
        $('#modal-book').modal('hide');
    }

    function pilihBook(id, kode) {
        $('#id').val(id);
        $('#title').val(kode);
        hideBook();
        tambahBook();
    }

    function tambahBook() {
    $.post('{{ route('transaction_detail.store') }}', $('.form-book').serialize())
        .done(response => {
            $('#title').focus();
            table.ajax.reload();
        })
        .fail(errors => {
            alert('Tidak dapat menyimpan data');
            return;
        });
    }
        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': '{{csrf_token()}}',
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }
</script>
@endsection