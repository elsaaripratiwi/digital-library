<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini
use App\Models\Book; // Tambahkan ini

class Publisher extends Model
{
   use HasFactory;
    
    protected $fillable = ['name'];

    /**
     * Definisi relasi: Satu Publisher memiliki banyak Books.
     * Menggunakan HasMany.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    } 
}
