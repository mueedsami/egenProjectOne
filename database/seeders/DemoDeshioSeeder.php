<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class DemoDeshioSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing demo data (optional)
        // Category::truncate();
        // Product::truncate();
        // ProductImage::truncate();

        $basePath = 'template/images/';

        // === MAIN CATEGORIES ===
        $mainCategories = [
            ['name' => 'Men', 'slug' => 'men', 'icon_url' => $basePath . 'aksesuar1.jpg'],
            ['name' => 'Women', 'slug' => 'women', 'icon_url' => $basePath . 'aksesuar2.jpg'],
            ['name' => 'Couples', 'slug' => 'couples', 'icon_url' => $basePath . 'aksesuar3.jpg'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'icon_url' => $basePath . 'aksesuar4.jpg'],
            ['name' => 'Winter', 'slug' => 'winter', 'icon_url' => $basePath . 'aksesuar5.jpg'],
            ['name' => 'Heritage', 'slug' => 'heritage', 'icon_url' => $basePath . 'aksesuar6.jpg'],
        ];

        foreach ($mainCategories as $cat) {
    $main = Category::firstOrCreate(
        ['slug' => $cat['slug']], // find existing by slug
        $cat                      // if not found, create new
    );

    // === SUBCATEGORIES ===
    $subcats = [
        'Tops', 'Bottoms', 'Outerwear', 'Footwear', 'Ethnic Wear', 'Exclusive Drops'
    ];
    foreach ($subcats as $sub) {
        $subSlug = Str::slug($main->slug . '-' . $sub);

        $subcat = Category::firstOrCreate(
            ['slug' => $subSlug],
            [
                'name' => $sub,
                'parent_id' => $main->id,
                'icon_url' => $basePath . 'aksesuar' . rand(1, 10) . '.jpg',
            ]
        );

        // === PRODUCTS ===
        for ($i = 1; $i <= 5; $i++) {
            $name = "{$main->name} {$sub} {$i}";
            $slug = Str::slug($name . '-' . $subcat->id);

            $p = Product::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'category_id' => $subcat->id,
                    'description' => "A stylish {$sub} from the Deshio {$main->name} collection.",
                    'price' => rand(1200, 3000),
                    'discount_price' => rand(900, 1200),
                    'stock_qty' => rand(3, 15),
                ]
            );

            // === PRODUCT IMAGES ===
            ProductImage::firstOrCreate(
                ['product_id' => $p->id],
                [
                    'image_url' => $basePath . 'aksesuar' . rand(1, 10) . '.jpg',
                    'is_primary' => true,
                ]
            );
        }
    }
}

    }
}
