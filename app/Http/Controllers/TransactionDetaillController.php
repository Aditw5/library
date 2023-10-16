<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetaillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction_id = session('id');
        $book = Book::orderBy('title')->get();
        $member = Member::find(session('member_id'));

        if (!$member) {
            // Handle the case where member is not found
            return redirect()->back()->with('error', 'Member not found');
        }

        return view('admin.transaction_detail.index', compact('transaction_id', 'book', 'member'));
    }

    public function data($id)
    {
        $detail = TransactionDetail::with('book')
            ->where('transaction_id', $id)
            ->get();
        
            
        $data = array();
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['title'] = $item->book['title'];
            $row['qty']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id .'" value="'. $item->qty .'">';
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('transaction_detail.destroy', $item->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;
            $total_item += $item->qty;
        }
        $data[] = [
            'title' => '',
            'qty'      => '',
            'date_start'    => '',
            'date_end'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'qty'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        $book = Book::where('id', $request->id)->first();
        if (! $book) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new TransactionDetail();
        $detail->transaction_id = $request->transaction_id;
        $detail->book_id = $book->id; 
        $detail->qty = 1;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }


    /**
     * 
     * 
     * Display the specified resource.
     */
    public function show(TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $detail = TransactionDetail::find($id);
        $detail->qty = $request->qty;
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detail = TransactionDetail::find($id);

        if ($detail) {
            $detail->delete();
            return response(null, 204);
        } else {
            // Handle jika tidak menemukan catatan
            return response('Purchase detail not found', 404);
        }
        
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah')
        ];

        return response()->json($data);
    }
}
