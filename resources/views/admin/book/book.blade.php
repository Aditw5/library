@extends('layouts.admin')
@section('header', 'Book')

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-md-5 offset-md-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" autocomplete="off" placeholder="Search Form Title" v-model="search">
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" @click="addData()"> Create New Book</button>
        </div>
    </div>
    <hr>
    <!-- Panel Kolom Card -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12" v-for="book in filterList">
            <div class="info-box" v-on:click="editData(book)" >
                <div class="info-box-content">
                    <span class="info-box-text h5">@{{ book.title }} (@{{ book.qty }})</span>
                    <span class="info-box-number">Rp.@{{ numberWithSpaces(book.price) }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form :action="actionUrl" method="post" autocomplete="off" @submit="submitForm($event, book.id)">
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
                                <label>ISBN</label>
                                <input name="isbn" :value="book.isbn" type="number" required="" class="form-control" placeholder="Enter ISBN">
                            </div>
                            <div class="form-group">
                                <label>Publisher</label>
                                <select class="form-control"  name="publisher_id" required autocomplete="off">
                                    <option value="">Choose Publisher</option>
                                    @foreach($publishers as $publisher)
                                    <option :selected="book.publisher_id == {{$publisher->id}}" value="{{$publisher->id}}">{{$publisher->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Author</label>
                                <select class="form-control"  name="author_id" required autocomplete="off">
                                    <option value="">Choose Author</option>
                                    @foreach($authors as $author)
                                    <option :selected="book.author_id == {{$author->id}}" value="{{$author->id}}">{{$author->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>catalog</label>
                                <select class="form-control"   name="catalog_id" required autocomplete="off">
                                    <option value="">Choose Catalog</option>
                                    @foreach($catalogs as $catalog)
                                    <option :selected="book.catalog_id == {{$catalog->id}}" value="{{$catalog->id}}">{{$catalog->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input :value="book.title" name="title" type="text" required="" class="form-control" placeholder="Enter Title">
                            </div>
                            <div class="form-group">
                                <label>Year</label>
                                <input :value="book.year" name="year" type="year" required="" class="form-control" placeholder="Enter Year">
                            </div>
                            <div class="form-group">
                                <label>Quantity Stock</label>
                                <input :value="book.qty" name="qty" type="number" required="" class="form-control" placeholder="Enter QTY Stock">
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input :value="book.price" name="price" type="number" required="" class="form-control" placeholder="Enter Price">
                            </div>
                            
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" v-if="editStatus"  v-on:click="deleteData(book.id)" data-dismiss="modal">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
            </div>
    </div>
</div>

<!-- modal create/add data -->

@endsection

@section('js')
<script type="text/javascript">
    var actionUrl = '{{url('books')}}';
    var apiUrl  = '{{url('api/books')}}';

    var app = new Vue({
        el: '#controller',
        data: {
            books: [],
            search: '',
            book: {},
            actionUrl,
            apiUrl,
            editStatus: false
        },
        mounted: function () {
            this.get_books();
        },
        methods: {
            get_books() {
                const _this = this;
                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    success: function (data) {
                        _this.books = JSON.parse(data); 
                    },
                    error: function (error){
                        console.log(error);
                    }
                })
            },
            numberWithSpaces(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
            addData() {
                this.book = {};
                this.editStatus = false;
                $('#modal-default').modal();
            },
            editData(book) {
                this.book = book;
                this.editStatus = true;
                $('#modal-default').modal();
            },
            deleteData(id) {
                if (confirm("Are You Sure ?")) {
                    axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response => {
                        // location.reload();
                        alert('Data Has Been Remove');
                        // location.reload();
                    });
                }
            },
            submitForm(event, id) {
                event.preventDefault();
                const _this = this;
                var actionUrl = ! this.editStatus ? this.actionUrl : this.actionUrl+'/'+id;
                axios.post(actionUrl, new FormData($(event.target)[0])).then(response =>{
                    $('#modal-default').modal('hide');
                    _this.table.ajax.reload();
                });
            },
        },
        computed: {
            filterList() {
                return this.books.filter(book => {
                    return book.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        }
    })
</script>
@endsection