<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdController extends Controller
{
    //
    public function addPostPage()
    {
        $categories = $this->categories();
        return view('frontend.pages.ad.post-ad', ['categories' => $categories]);
    }

    public function adListingPage($category_slug = null)
    {
        return view('frontend.pages.ad.listing', compact('category_slug'));
    }

    public function categories()
    {
        return [
            'electronics' => [
                'name' => 'Electronics',
                'subcategories' => [
                    'mobile_phones' => [
                        'name' => 'Mobile Phones',
                        'subcategories' => [
                            'smartphones' => 'Smartphones',
                            'feature_phones' => 'Feature Phones',
                            'phone_accessories' => 'Phone Accessories'
                        ]
                    ],
                    'computers' => [
                        'name' => 'Computers',
                        'subcategories' => [
                            'laptops' => 'Laptops',
                            'desktops' => 'Desktops',
                            'tablets' => 'Tablets',
                            'computer_accessories' => 'Computer Accessories'
                        ]
                    ],
                    'tv_audio' => [
                        'name' => 'TV & Audio',
                        'subcategories' => [
                            'televisions' => 'Televisions',
                            'speakers' => 'Speakers',
                            'headphones' => 'Headphones'
                        ]
                    ],
                    'cameras' => 'Cameras & Photography'
                ]
            ],
            'vehicles' => [
                'name' => 'Vehicles',
                'subcategories' => [
                    'cars' => [
                        'name' => 'Cars',
                        'subcategories' => [
                            'sedan' => 'Sedan',
                            'suv' => 'SUV',
                            'hatchback' => 'Hatchback',
                            'coupe' => 'Coupe'
                        ]
                    ],
                    'motorcycles' => [
                        'name' => 'Motorcycles',
                        'subcategories' => [
                            'sport_bikes' => 'Sport Bikes',
                            'cruisers' => 'Cruisers',
                            'scooters' => 'Scooters'
                        ]
                    ],
                    'auto_parts' => 'Auto Parts & Accessories',
                    'boats' => 'Boats'
                ]
            ],
            'real_estate' => [
                'name' => 'Real Estate',
                'subcategories' => [
                    'apartments' => [
                        'name' => 'Apartments',
                        'subcategories' => [
                            'studio' => 'Studio',
                            'one_bedroom' => '1 Bedroom',
                            'two_bedroom' => '2 Bedroom',
                            'three_plus_bedroom' => '3+ Bedroom'
                        ]
                    ],
                    'houses' => [
                        'name' => 'Houses',
                        'subcategories' => [
                            'single_family' => 'Single Family',
                            'townhouse' => 'Townhouse',
                            'villa' => 'Villa'
                        ]
                    ],
                    'commercial' => 'Commercial Property',
                    'land' => 'Land & Plots'
                ]
            ],
            'jobs' => [
                'name' => 'Jobs',
                'subcategories' => [
                    'it_software' => [
                        'name' => 'IT & Software',
                        'subcategories' => [
                            'web_development' => 'Web Development',
                            'mobile_development' => 'Mobile Development',
                            'data_science' => 'Data Science'
                        ]
                    ],
                    'sales_marketing' => 'Sales & Marketing',
                    'hospitality' => 'Hospitality',
                    'education' => 'Education & Training'
                ]
            ],
            'furniture' => [
                'name' => 'Furniture',
                'subcategories' => [
                    'living_room' => [
                        'name' => 'Living Room',
                        'subcategories' => [
                            'sofas' => 'Sofas & Couches',
                            'coffee_tables' => 'Coffee Tables',
                            'tv_stands' => 'TV Stands'
                        ]
                    ],
                    'bedroom' => [
                        'name' => 'Bedroom',
                        'subcategories' => [
                            'beds' => 'Beds',
                            'wardrobes' => 'Wardrobes',
                            'dressers' => 'Dressers'
                        ]
                    ],
                    'office_furniture' => 'Office Furniture',
                    'outdoor_furniture' => 'Outdoor Furniture'
                ]
            ],
            'services' => [
                'name' => 'Services',
                'subcategories' => [
                    'home_services' => [
                        'name' => 'Home Services',
                        'subcategories' => [
                            'cleaning' => 'Cleaning',
                            'plumbing' => 'Plumbing',
                            'electrical' => 'Electrical'
                        ]
                    ],
                    'professional_services' => 'Professional Services',
                    'tutoring' => 'Tutoring & Lessons'
                ]
            ]
        ];
    }
}
