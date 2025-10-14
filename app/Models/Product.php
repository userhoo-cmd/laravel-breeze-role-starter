<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'barcode',
        'price',
        'quantity',
        'status',
    ];

    /**
     * ✅ Accessor: Return full URL for image or fallback placeholder.
     */
    public function getImageUrlAttribute()
    {
        // Check if image path exists in storage (e.g., storage/app/public/products/filename.jpg)
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }

        // If image field contains a full or partial path accessible via public/
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        // Fallback placeholder image
        return asset('images/img-placeholder.jpg');
    }

    /**
     * ✅ Helper: Check if product is active.
     */
    public function isActive()
    {
        return $this->status === 'active' || $this->status === 1;
    }
}
