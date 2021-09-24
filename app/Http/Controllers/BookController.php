<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class BookController extends Controller
{
    public function externalbook() {
        $nameofbook = request('name');
        $responses = Http::get("https://www.anapioficeandfire.com/api/books?name=$nameofbook");
        if ($responses->successful()) {
            $finalresponse = [];
            foreach ($responses->json() as $response) {
                $data = [
                    "name" => $response["name"],
                    "isbn" => $response["isbn"],
                    "authors" => $response['authors'],
                    "number_of_pages" => $response['numberOfPages'],
                    "publisher" => $response['publisher'],
                    "country" => $response['country'],
                    "release_date" => $response['released']
                ];
                $objectdata = json_decode(json_encode($data), FALSE);
                array_push($finalresponse, $objectdata);
            }
            return response([
                "status_code" => 200,
                "status" => "status",
                "data" => $finalresponse
            ], 200);
           
        }
    }
    public function getview ($id) {
        return view('edit', compact('id'));
    }
    public function getbooks() {
        $books = Book::get();
        foreach($books as $book) {
            $authors = json_decode($book->authors);
            $book->authors = $authors;
        }
        return response([
            "status_code" => 200,
            "message" => "Book retrived successully.",
            "status" => "success",
            "data" => $books
        ], 200);
    }

    public function singlebook($id) {
        $book = Book::where('id', $id)->first();
        if ($book == null) {
            return  response(["message" => "No books", "status" => "error", "book" => null ], 200);
        }
        return response(["message" => "Single book", "status" => "success", "book" => $book], 200);
    }

    public function deletebook($id) {
        $book = Book::where("id",$id)->first();
        $book->delete();
        return response([
            "status_code" => 204,
            "status" => "success",
            "message" => "The book My First Book was deleted successfully",
            "data" => []
        ], 200);
    }

    public function editbook(Request $request, $id) {
        $request->validate([
            "name" => "required|string",
            "isbn" => "required|string",
            "authors" => "required|string",
            "country" => "required|string",
            "number_of_pages" => "required|integer",
            "publisher" => "required|string",
            "release_date" => "required|string"
        ]);
        $book = Book::where("id",$id)->first();
        if ($book == null) {
            return response([
                "status_code" => 200,
                "status" => "success",
                "message" => "No Book available.",
            ], 200);
        }
        $book->update([
            "name" => $request->name,
            "isbn" => $request->isbn,
            "authors" => json_encode([$request->authors]),
            "country" => $request->country,
            "number_of_pages" => $request->number_of_pages,
            "publisher" => $request->publisher,
            "release_date" => $request->release_date
        ]);
        $book->save();
        return response([
            "status_code" => 200,
            "status" => "success",
            "message" => "The book My First Book was updated successfully.",
            "data" => $book
        ], 200);
    }
    public function createbook(Request $request) {
        $request->validate([
            "name" => "required|string",
            "isbn" => "required|string",
            "authors" => "required|string",
            "country" => "required|string",
            "number_of_pages" => "required|integer",
            "publisher" => "required|string",
            "release_date" => "required|string"
        ]);
        $newbook = Book::create([
            "name" => $request->name,
            "isbn" => $request->isbn,
            "authors" => json_encode([$request->authors]),
            "country" => $request->country,
            "number_of_pages" => $request->number_of_pages,
            "publisher" => $request->publisher,
            "release_date" => $request->release_date
        ]);
        return response([
            "status_code" => 201,
            "status" => "success",
            "data" => $newbook
        ], 201);
    }
}
