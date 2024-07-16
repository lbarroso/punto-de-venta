<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Manipulations;
use Illuminate\Support\Str;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['artcve','artdesc','category_id','codbarras','rtcolor','artestilo','artmarca','stock',
		'artimg','artprcosto','artprventa','artpesogrm','artpesoum','artganancia', 'proveedor_id', 'artstatus', 'slug'
	];   
    
    protected function slug(): Attribute{
        return Attribute::make(
            set: fn ($value) => Str::slug($this->artdesc)
        );
    }
	
    protected function DiscountCurrent(): Attribute{
        $dateNow = Carbon::now()->timezone('America/Mexico_City')->format('Y-m-d');

        return Attribute::make(
            get: fn ($value,$attributes) => ProductDiscount::where('date_start','<=',$dateNow)
            ->where('date_end','>=',$dateNow)
            ->where('product_id',$attributes['id'])
            ->first()->percentage ?? 0
        );
    }

    // muchos productos pertenecen a una categoria
    public function category(){

        return $this->belongsTo(Category::class);
    }

    //
    public function proveedor(){
                
        return $this->belongsTo(Proveedor::class);
    }

	// conversion de media
	// cambiar tamaños de imagenes
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }
  
    public function discounts(){
        return $this->hasMany(ProductDiscount::class);
    }

    public function properties(){
        return $this->hasMany(ProductProperty::class);
    }    

} // class
