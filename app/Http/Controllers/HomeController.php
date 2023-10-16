<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Catalog;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function dashboard()
     {
         $total_buku = Book::count();
         $total_anggota = Member::count();
         $total_penerbit = Publisher::count();
         $total_peminjaman = Transaction::whereMonth('date_start', date('m'))->count();

         $data_donut = Book::select(DB::raw("COUNT(publisher_id) as total"))->groupBy('publisher_id')->orderBy('publisher_id', 'asc')->pluck('total');
         $label_donut = Publisher::orderBy('publishers.id', 'asc')->join('books', 'books.publisher_id', '=', 'publishers.id')->groupBy('name')->pluck('name');
     
         // Dump the values for debugging
        //  dump($total_buku, $total_anggota, $total_penerbit, $total_peminjaman);

        // return $label_donut;
        // dump($data_donut, $label_donut);

        $label_bar = ['Peminjaman'];
        $data_bar = [];

        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = 'rgba(60,141,188, 0.9)';
            $data_month = [];
                foreach (range(1,12) as $month ) {
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_start', $month)->first()->total;
                }
                $data_bar[$key] = $data_month;
        }
        // return $data_bar;
     
         return view('dashboard', compact('total_buku', 'total_anggota', 'total_penerbit', 'total_peminjaman', 'data_donut', 'label_donut'));
     }
    

    public function index()
    {
        $data = Member::select('*')
                    ->join('users','users.member_id','=','members.id')
                    ->get();

        $data2 = Member::select('*')
                    ->Leftjoin('users','users.member_id','=','members.id')
                    ->where('users.id', NULL)
                    ->get();

        $data3 = Transaction::select('members.id', 'members.name')
                    ->Rightjoin('members','members.id','=','transactions.member_id')
                    ->where('transactions.member_id', NULL)
                    ->get();

        $data4 = Member::select('members.id', 'members.name', 'members.phone_number')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->get();

        $data5 = Member::select('members.id', 'members.name', 'members.phone_number')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->groupby('members.id', 'members.name', 'members.phone_number')
                    ->havingRaw('COUNT(transactions.member_id) > 1')
                    ->get();

        $data6 = Member::select('members.name', 'members.address', 'members.phone_number','transactions.date_start', 'transactions.date_end')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->get();

        $data7 = Member::select('members.name', 'members.address', 'members.phone_number','transactions.date_start', 'transactions.date_end')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->whereRaw('MONTH(transactions.date_end) = 6')
                    ->get();

        $data8 = Member::select('members.name', 'members.address', 'members.phone_number','transactions.date_start', 'transactions.date_end')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->whereRaw('MONTH(transactions.date_start) = 5')
                    ->get();

        $data9 = Member::select('members.name', 'members.address', 'members.phone_number','transactions.date_start', 'transactions.date_end')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->whereRaw('MONTH(transactions.date_start) = 6 AND MONTH(transactions.date_end) = 6')
                    ->get();

        $data10 = Member::select('members.name', 'members.address', 'members.phone_number','transactions.date_start', 'transactions.date_end')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->where('members.address', 'like', '%Bandung%')
                    ->get();

        $data11 = Member::select('members.name', 'members.address', 'members.phone_number','transactions.date_start', 'transactions.date_end')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->where(function ($query) {
                        $query->where('members.address', 'like', '%Bandung%')
                              ->where('members.gender', 'like', '%M%');
                    })
                    ->get();

        $data12 = Member::select('members.name', 'members.address', 'members.phone_number', 'transactions.date_start', 
                    'transactions.date_end', 'transaction_details.qty')
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                    ->whereIn('members.id', function($query) {
                        $query->select('members.id')
                              ->from('members')
                              ->join('transactions', 'transactions.member_id', '=', 'members.id')
                              ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                              ->groupBy('members.id')
                              ->havingRaw('transaction_details.qty > 1');
                    })
                    ->get();

        $data13 = Member::select('members.name', 'members.address', 'members.phone_number',
                'transactions.date_start', 'transactions.date_end', 'transaction_details.qty', 
                'books.title', 'books.price')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                    ->join('books', 'books.id', '=', 'transaction_details.book_id')
                    ->get();

        $data14 = Member::select(
                        'members.name AS member_name',
                        'members.address AS member_address',
                        'members.phone_number AS member_phone',
                        'transactions.date_start AS transaction_start',
                        'transactions.date_end AS transaction_end',
                        'transaction_details.qty AS transaction_qty',
                        'books.title AS book_title',
                        'books.price AS book_price',
                        'publishers.name AS publisher_name',
                        'authors.name AS author_name',
                        'catalogs.name AS catalog_name'
                    )
                    ->join('transactions', 'transactions.member_id', '=', 'members.id')
                    ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                    ->join('books', 'books.id', '=', 'transaction_details.book_id')
                    ->join('publishers', 'publishers.id', '=', 'books.publisher_id')
                    ->join('authors', 'authors.id', '=', 'books.author_id')
                    ->join('catalogs', 'catalogs.id', '=', 'books.catalog_id')
                    ->get();
        
        $data15 = Catalog::select('catalogs.id', 'catalogs.name', 'books.title')
                ->join('books', 'books.catalog_id', '=', 'catalogs.id')
                ->get();

        $data16 = Book::select('books.*', 'publishers.name AS Publisher_Name')
                ->leftjoin('publishers', 'publishers.id', '=', 'books.publisher_id')
                ->where('books.publisher_id', NULL)
                ->get();
        
        $data18 = Book::select('*')
                ->where('price', '>', 10000)
                ->get();

        $data19 = Book::select('books.title', 'books.year', 'books.publisher_id', 'books.qty')
                ->where(function ($query) {
                    $query->where('books.publisher_id', '=', '33')
                        ->where('books.qty', '>', 10);
                })
                ->get();
        
        // $data20 Tidak ada tanggal entry nya
            
                    
        // $members = Member::with('user')->get();
        // $books = Book::with('publisher', 'author', 'catalog')->get();
        // $publisher = Publisher::with('books')->get();
        // return $data19;
        return view('home');
    }
}
