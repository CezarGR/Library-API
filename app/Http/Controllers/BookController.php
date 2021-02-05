<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

        
    public function index()
    {
        $book = Book::all();   
        return response()->json($book);

        //return 'oi';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title'=> 'required|min:1',
            'author'=> 'required|min:1',
            'genre'=> 'required|min:1'
        ]);

        $bookTitle = Book::where('title', $request->title)->first(); // se nao achar false 
        $bookAuthor = Book::where('author', $request->author)->first(); // se nao achar false 

        if($bookTitle && $bookAuthor){
            return response()->json([
                'message' => 'Book already created',
            ], 401);
        }else{
           $book = Book::create($request->all());
            return response()->json([
                'message' => 'Book successfully created',
                'book' => $book
            ]);
        }
        
        
        
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $book -> update($request->all());
        return response()->json([
            'message' => 'Successfully updated book',
            'book' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $book = Book::find($id);
        Book::destroy($id);
        return response()->json([
            'message' => 'Book successfully deleted',
            'book' => $book
        ]);
    }
}
