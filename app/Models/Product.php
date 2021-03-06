<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'existence',
        'size',
        'boarding',
        'brand_id',
        'disabled'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

}
