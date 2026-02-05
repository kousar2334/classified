<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PricingPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:250',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'listing_quantity' => 'required|integer|min:0',
            'featured_listing_quantity' => 'required|integer|min:0',
            'gallery_image_quantity' => 'required|integer|min:0',
            'membership_badge' => 'nullable|in:0,1',
            'online_shop' => 'required|in:0,1',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => translation('Plan title is required'),
            'duration_days.required' => translation('Duration days is required'),
            'duration_days.min' => translation('Duration must be at least 1 day'),
            'price.required' => translation('Price is required'),
            'price.numeric' => translation('Price must be a number'),
            'listing_quantity.required' => translation('Listing quantity is required'),
            'featured_listing_quantity.required' => translation('Featured listing quantity is required'),
            'gallery_image_quantity.required' => translation('Gallery image quantity is required'),
        ];
    }
}
