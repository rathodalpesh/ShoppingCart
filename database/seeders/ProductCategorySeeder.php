<?php

namespace Database\Seeders;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $websiteData = array();

        $website     = ProductCategory::select('id', 'cat_name')->pluck('cat_name', 'id')->toArray();
         
        if( !in_array('Mobile', $website) ) {
            $websiteData[] = [
                'cat_name' => 'Mobile',
            ];
        }
        if( !in_array('Car', $website) ) {
            $websiteData[] = [
                'cat_name' => 'Car',
            ];
        }
        if( !in_array('Refrigerator', $website) ) {
            $websiteData[] = [
                'cat_name' => 'Refrigerator',
            ];
        }
        if( !in_array('Clothes', $website) ) {
            $websiteData[] = [
                'cat_name' => 'Clothes',
            ];
        }
        return ProductCategory::insert($websiteData);
    }
}
