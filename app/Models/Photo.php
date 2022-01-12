<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    
    protected $table = 'photo';
    
    protected $fillable = [
        'name',
        'file_path'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }       
}
