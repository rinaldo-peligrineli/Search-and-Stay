<?php

namespace Tests\Feature;

use App\Models\BookStore;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookStoreTest extends TestCase
{
    private $path = 'api/bookstore/book';


    public function teste_book_require_isbn(){

        $arrBook = [
            "name" => "Book 2",
            "value" => "1345.56"
        ];

        $url = sprintf('%s/%s', $this->path, 'store');
        $this->post($url, $arrBook)
                ->assertSessionHasErrors(['isbn']);
    }

    public function test_create_book()
    {
        $arrBook = [
            "name" => "Book 2",
            "value" => "1345.56",
            "isbn" => "54"
        ];

        $url = sprintf('%s/%s', $this->path, 'store');
        $this->postJson($url, $arrBook)
            ->assertOk();
    }
}
