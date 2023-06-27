<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user) {
        parent::__construct($user);
    }

    public function getUsers()
    {
        return  $this->model->all()->paginate(10);
    }
}
