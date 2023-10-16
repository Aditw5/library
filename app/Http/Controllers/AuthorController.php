<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.author.author');
    }

    public function api()
    {
        $authors = Author::all();
        $datatables = datatables()->of($authors)->addIndexColumn();

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
            'email' => ['required'],
            'phone_number' => ['required', 'numeric'],
            'address' => ['required'],
        ]);

        Author::create($request->all());

        return redirect('authors');
        // return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required', 'numeric'],
            'address' => ['required'],
        ]);
        
        $author->update($request->all());

        return redirect('authors');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
    }
}
