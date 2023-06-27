<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\BookStore;

class BookRepository extends BaseRepository
{
    public function __construct(BookStore $bookStore) {
        parent::__construct($bookStore);
    }

    public function getBooks()
    {
        return  $this->model->paginate(10);
    }
}
