<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];
    
    // una categotia tiene muchos productos
    public function products(){
        return $this->hasMany(Product::class);
    }    

    protected function slug(): Attribute{
        return Attribute::make(
            set: fn ($value) => Str::slug($this->name)
        );
    }    

}
