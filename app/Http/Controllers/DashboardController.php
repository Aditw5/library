<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Catalog;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
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

    public function test_spatie()
    {
        // $role = Role::create(['name' => 'writer']);
        // $permission = Permission::create(['name' => 'index Transaction']);

        // $role->givePermissionTo($permission);
        // $permission->assignRole($role);

        // $user = auth()->user();
        // $user->assignRole('writer');

        $user = User::with('roles')->get();

        // $user = User::where('id', 4)->first();
        // $user->removeRole('writer');

        return $user;
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

        $data_donut = Book::select(DB::raw("COUNT(publisher_id) as total"))
            ->groupBy('publisher_id')
            ->orderBy('publisher_id', 'asc')
            ->pluck('total');
        $label_donut = Publisher::orderBy('publishers.id', 'asc')
            ->join('books', 'books.publisher_id', '=', 'publishers.id')
            ->groupBy('publishers.id', 'name')
            ->pluck('name');

        $data_author = Book::select(DB::raw("COUNT(author_id) as total"))
            ->groupBy('author_id')
            ->orderBy('author_id', 'asc')
            ->pluck('total');
        $label_author = Author::orderBy('authors.id', 'asc')
            ->join('books', 'books.author_id', '=', 'authors.id')
            ->groupBy('authors.id', 'name')
            ->pluck('name');

        $label_bar = ['Peminjaman', 'Pengembalian'];
        $data_bar = [];

        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = $key == 0 ? 'rgba(60,141,188, 0.9)' : 'rgba(210,214,222, 1)';
            $data_month = [];
            foreach (range(1, 12) as $month) {
                if ($key == 0) {
                    $data_month[] = Transaction::whereMonth('date_start', $month)->count();
                } else
                $data_month[] = Transaction::whereMonth('date_end', $month)->count();
            }
            $data_bar[$key]['data'] = $data_month;
        }
        //  return $label_author;
        // dump($data_author, $label_author);

        return view('dashboard', compact('data_author', 'label_author', 'total_buku', 'total_anggota', 'total_penerbit', 'total_peminjaman', 'data_donut', 'label_donut', 'data_bar'));
    }

    public function index()
    {
        return view('dashboard');
    }
}
