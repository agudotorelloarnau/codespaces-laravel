<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $table = 'series';

    //el fillable se utiliza para que solo los campos que estan puestos se puedan asignar.
    protected $fillable = [
        'title',
        'genre',
        'release_year',
    ];


    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
