<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class BookStore extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'books_store';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'isbn',
        'user_id',
        'value',

    ];

    /**
     * This function is used to format value in brazilian format,
     * if this is a case, just uncoment
     *
     * @param $value
     */
    /*public function setValueAttribute($value)
    {
        $result = str_replace('.', '', $value);
        $result = str_replace(',', '.', $result);
        $this->attributes['value'] = $result;
    }*/
}
