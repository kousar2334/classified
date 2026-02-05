<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'duration_days',
        'price',
        'listing_quantity',
        'featured_listing_quantity',
        'gallery_image_quantity',
        'membership_badge',
        'online_shop',
        'status',
    ];
}
