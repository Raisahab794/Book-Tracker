<?php
// app/Services/IsbnLookupService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IsbnLookupService
{
    protected $baseUrl = 'https://www.googleapis.com/books/v1/volumes';

    public function lookup(string $isbn)
    {
        $response = Http::get($this->baseUrl, [
            'q' => "isbn:$isbn"
        ]);

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();
        
        if (empty($data['items'])) {
            return null;
        }

        $book = $data['items'][0]['volumeInfo'];

        return [
            'title' => $book['title'] ?? null,
            'author' => implode(', ', $book['authors'] ?? []),
            'description' => $book['description'] ?? null,
            'cover_image' => $book['imageLinks']['thumbnail'] ?? null,
            'page_count' => $book['pageCount'] ?? 0,
            'isbn' => $isbn
        ];
    }
}