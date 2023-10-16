<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::orderBy('name')->get();
        return view('admin.transaction.transaction', compact('members'));
    }

    public function api() 
    {

        $transactions = Transaction::leftJoin('members', 'transactions.member_id', '=', 'members.id')
            ->select('transactions.*', 'name')
            ->orderBy('id', 'desc')->get();

        return datatables()->of($transactions)
            ->addIndexColumn()
            ->addColumn('date_start', function ($transactions) {
                return $transactions->date_start;
            })
            ->addColumn('date_end', function ($transactions) {
                return $transactions->date_end;
            })
            ->addColumn('action', function ($transactions) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('transactions.show', $transactions->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $transaction = new Transaction();
        $transaction->member_id = $id;
        $transaction->date_start = null;
        $transaction->date_end = null;
        
        $transaction->save();
        
        return redirect()->route('transactions_detail.index')->with([
            'id' => $transaction->id,
            'member_id' => $transaction->member_id
        ]);
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $transaction = Transaction::findOrFail($request->transaction_id);
        $transaction->date_start = $request->date_start;
        $transaction->date_end= $request->date_end;
        $transaction->update();

        $details = TransactionDetail::where('transaction_id', $transaction->id)->get();
    
        foreach ($details as $detail) {
            $book = Book::find($detail->book_id);
            $book->qty -= $detail->qty;
            $book->update();
        }
    
        return redirect()->route('transactions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detail = TransactionDetail::with('book')->where('transaction_id', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('title', function ($detail) {
                return $detail->book->title;
            })
            ->addColumn('qty', function ($detail) {
                return $detail->qty;
            })
            ->rawColumns([])
            ->make(true);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
