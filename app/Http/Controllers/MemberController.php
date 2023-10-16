<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     if ($request->gender) {
    //         $datas = Member::where('gender', $request->gender)->get();
    //     } else {
    //         $datas = Member::all();
    //     }
    //     $datatables = datatables()->of($datas)->addIndexColumn();

    //     return $datatables->make(true);
    //     // return view('admin.member.member');
    // }

    public function index(Request $request)
    {
        $datas = Member::query();

        if ($request->gender) {
            $datas->where('gender', $request->gender);
        }

        $datatables = datatables()->of($datas)->addIndexColumn();

        if ($request->ajax()) {
            return $datatables->make(true);
        }

        return view('admin.member.member');
    }


    public function api() 
    {
        $members = Member::all();
        $datatables = datatables()->of($members)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'gender' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required', 'numeric'],
            'address' => ['required'],
        ]);

        Member::create($request->all());

        return redirect('members');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $this->validate($request, [
            'name' => ['required'],
            'gender' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required', 'numeric'],
            'address' => ['required'],
        ]);

        $member->update($request->all());

        return redirect('members');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
    }
}
