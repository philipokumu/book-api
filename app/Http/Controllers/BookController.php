<?php

namespace App\Http\Controllers;

use App\Http\Resources\Book as BookResource;
use App\Http\Resources\BookCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index()
    {
        $books_array = collect($this->fetchBooks())
            ->sortBy('released', SORT_REGULAR, true);

        $books = $books_array->map(function($book){
            return (object)$book;
        });

        return new BookCollection($books);
    }

    public function show($id)
    {
        $book = (object)$this->fetchBooks($id);
        // echo $id;


       return new BookResource($book);

    }

    private function fetchBooks($id=null)
    {
        $url = "https://anapioficeandfire.com/api/books/";

        // Fetch full list or fetch by id
        $full_fetch_url = $id ? $url . $id : $url;

        $response = Http::get($full_fetch_url);

        return json_decode($response->body(), 1);

    }
}
