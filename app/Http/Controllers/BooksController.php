<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function index(){
        return view('books.index');
    }

    public function store(Request $request){
        Book::create([
            'user_id' => Auth::user()->id,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'copies_sold' => 0,
        ]);
    }
}
